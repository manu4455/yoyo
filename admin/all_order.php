<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
date_default_timezone_set('Asia/kolkata');
//pagination
if(isset($_GET['limit'])){
  $limit = $_GET['limit']; 
}
else{
  $limit = 10; 
}
$result_db = mysqli_query($db,"SELECT COUNT(id) FROM  customers "); 
$row_db = mysqli_fetch_row($result_db);  
$total_records = $row_db[0];  
$total_pages = ceil($total_records / $limit); 
if (isset($_GET["page"])) {
  $page  = $_GET["page"]; 
  } 
  else{ 
  $page=1;
}
$start_from = ($page-1) * $limit;
$result = mysqli_query($db,"SELECT * FROM orders INNER JOIN products ON orders.product_id=products.product_id  INNER JOIN customers ON orders.customer_id=customers.id ORDER BY orders.id DESC LIMIT $start_from, $limit");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin | Panel</title>
    <?php include 'link.php'; ?>
</head>

<body class="bg-secondary">
    <div class="loader"></div>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include 'aside.php'; ?>
        <!-- Page Content  -->
        <div id="content">
            <?php include 'header.php'; ?>
            <div class="navigation col-12  bg-light justify-content-center justify-content-sm-left ">
                <div class="btn-group justify-content-center justify-content-sm-left">
                    <a href="all_order.php" class="btn btn-default navigator rounded-0"><i class="fa fa-first-order">
                            New Orders</i></a>
                </div>
            </div>
            <section class="main mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }?>
                            <div class="card">
                                <div class="card-header with-border">
                                    <div class="row ">
                                        <div class="col-6">
                                            <label>Search</label>
                                            <input type="text" name="search" id="search"
                                                class="form-control rounded">
                                        </div>
                                        <div class="col-6">
                                            <label>Sort</label>
                                            <select class="form-control rounded" name="sort" id="orderlimit">
                                              <option value="10"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==10){echo 'selected';}} ?>>10</option>
                                              <option value="20"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==20){echo 'selected';}} ?>>20</option>										
                                              <option value="50"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==50){echo 'selected';}} ?>>50</option>										
                                              <option value="100"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==100){echo 'selected';}} ?>>100</option>	
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                                    <table id="product" class="table table-bordered table-striped  text-sentance">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.no</th>
                                                <th class="text-center">Order ID</th>
                                                <th class="text-center w-10">Customer</th>
                                                <th class="text-center">Product(Name)</th>
                                                <th class="text-center">Product(Size)</th>
                                                <th class="text-center">Product(Color)</th>
                                                <th class="text-center">Quantity)</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Payment(Status)</th>
                                                <th class="text-center">Payment(mode)</th>
                                                <th class="text-center">Order(Date)</th>
                                                <th class="text-center">Image</th>   
                                                <th class="text-center">Status</th>                                              
                                            </tr>
                                        </thead>
                                        <tbody id="datatable">
                                            <?php
                                    $count_row=mysqli_num_rows($result);
                                    if($count_row>=1){
                                    $num=1;
                                    while ($row=mysqli_fetch_assoc($result)) {
                                    $i=0;
                                    $image=$row['images'];
                                    $get_image=explode(',',$image);
                                    //$d=$row['date'];
                                    $date = date("d-m-Y h:i:s a");
										
                                    ?>
                                            <tr>
                                                <td class="text-center"><?php echo $num; ?></td>
                                                <td class="text-center"><?php echo $row['order_id']; ?></td>
                                                <td class="text-center"><?php echo $row['names']; ?></td>
                                                <td class="text-center text-hides"><?php echo $row['product_name']; ?></td>
                                                <td class="text-center"><?php echo $row['size']; ?></td>
                                                <td class="text-center"><?php echo $row['order_color']; ?></td>
                                                <td class="text-left"><?php echo $row['quantity']; ?></td>
                                                <td class="text-left"><i class="fa fa-rupee"></i> <?php echo $row['total_amount']; ?></td>
                                                <td class="text-center"><?php echo $row['payment']; ?></td>
                                                <td class="text-center text-hides"><?php echo $row['payment_mode']; ?></td>
                                                <td class="text-center"><?php echo $date; ?></td>
                                                <td class="text-center" height="60" width="80"><img src="../images/items/<?php echo $get_image[$i]; ?>" alt="image" class="img-fluid"></td>
                                                <td class="text-center">
                                                    <?php  
                                                    if($row['new']==1){
                                                        echo '<p class="text-danger text-bold"><i class="fa fa-clock-o"></i> Pending</p>';
                                                    }
                                                    if($row['received']==1){
                                                        echo '<p class="text-success text-bold"><i class="fa fa-clock-o"></i> Received</p>';
                                                    }
                                                    if($row['packed']==1){
                                                        echo '<p class="text-danger text-bold"><i class="fa fa-clock-o"></i> Packed</p>';
                                                    }
                                                    if($row['shipped']==1){
                                                        echo '<p class="text-success text-bold"><i class="fa fa-clock-o"></i> Shipped</p>';
                                                    }
                                                    if($row['dilivered']==1){
                                                        echo '<p class="text-danger text-bold"><i class="fa fa-clock-o"></i> Delivered</p>';
                                                    }
                                                    if($row['cancel']==1 ){
                                                        echo '<p class="text-success text-bold"><i class="fa fa-clock-o"></i> cancelled</p>';
                                                    }
                                                    ?>
                                                </td>                                           
                                            </tr>
                                            <?php
                                      $num++;
                                    }
                                  }
                                  else{
                                    ?>
                                            <tr>
                                                <td colspan="15">No order yet !</td>
                                            </tr>
                                            <?php
                                  } 
                                  ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">S.no</th>
                                                <th class="text-center">Order ID</th>
                                                <th class="text-center w-10">Customer</th>
                                                <th class="text-center">Product(Name)</th>
                                                <th class="text-center">Product(Size)</th>
                                                <th class="text-center">Product(Color)</th>
                                                <th class="text-center">Quantity)</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Payment(Status)</th>
                                                <th class="text-center">Payment(mode)</th>
                                                <th class="text-center">Order(Date)</th>
                                                <th class="text-center">Image</th>                                        
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a
                                                    class="page-link"
                                                    href="product_summary.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>"
                                                    tabindex="-1" aria-disabled="true">Previous</a></li>
                                            <?php
                                      for ($i=1; $i<=$total_pages; $i++) {
                                      ?>
                                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a
                                                    class="page-link"
                                                    href="product_summary.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                            <?php
                                      }
                                      ?>
                                            <li class="page-item <?php if($page==$total_pages){echo 'disabled';} ?>"><a
                                                    class="page-link"
                                                    href="product_summary.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js">
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(document).ready(function() {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
    </script>
</body>

</html>