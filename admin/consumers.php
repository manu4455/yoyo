<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
if(isset($_GET['parent'])){
  $parent=$_GET['parent'];
}
else{
  $parent=0;
} 
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
$result = mysqli_query($db,"SELECT * FROM customers INNER JOIN country on customers.country=country.id INNER JOIN states on customers.states=states.id INNER JOIN city on customers.city=city.id
LIMIT $start_from, $limit");
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
                    <a href="consumers.php" class="btn btn-default navigator rounded-0"><i class="fa fa-users"> Consumers</i></a>
                </div>
            </div>
            <section class="main mt-2">
        <div class="container-fluid">
          <div class="row">
              <!-- left column -->
              <div class="col-12">           
              <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }?>
                <div class="card">
                  <div class="card-header">
                    <div class="row ">
                      <div class="col-6">
                        <label>Search</label>
                        <input type="text" name="search" id="search" class="form-control rounded">
                      </div>
                      <div class="col-6">
                        <label>Sort</label>
                        <select class="form-control rounded" name="sort" id="consumerlimit">
                          <option value="10"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==10){echo 'selected';}} ?>>10</option>
                          <option value="20"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==20){echo 'selected';}} ?>>20</option>										
                          <option value="50"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==50){echo 'selected';}} ?>>50</option>										
                          <option value="100"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==100){echo 'selected';}} ?>>100</option>	
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="card-body mt-1 table-responive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                    <table id="example1" class="table table-bordered table-striped w-100">
                      <thead>
                        
                        <tr>
                          <th class="text-center">S.no</th>
                          <th class="text-center">Name</th>
                          <th class="text-center">Gender</th>
                          <th class="text-center">Country</th>
                          <th class="text-center">State</th>
                          <th class="text-center">Cities</th>
                          <th class="text-center">Pin</th>
                          <th class="text-center">Phone</th>
                          <th class="text-center">Address</th>
                          <th class="text-center">Image</th>
                        </tr>
                        
                      </thead>
                      <tbody class="text-center" id="datatable">
                        <?php
                          $count_row=mysqli_num_rows($result);
                          if($count_row>=1){
                          $num=1;
                          while($row=mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                          <td><?php echo $num; ?></td>
                          <td><?php echo $row['names']; ?></td>
                          <td><?php echo $row['gender']; ?></td>
                          <td><?php echo $row['country_name']; ?></td>
                          <td><?php echo $row['state_name']; ?></td>
                          <td><?php echo $row['city_name']; ?></td>                          
                          <td><?php echo $row['pin']; ?></td>
                          <td><?php echo $row['phone']; ?></td>
                          <td><?php echo $row['addres']; ?></td>
                          <td><img src="../images/avatars/<?php echo $row['image']; ?>" alt="image" class="img-fluid img-sm"></td>
                          
                        </tr>
                          <?php
                          $num++;
                          }
                        }
                        else{
                          ?>
                          <tr class="text-left"><td colspan="4">No Consumers Found !</td></tr>
                          <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="text-center">S.no</th>
                          <th class="text-center">Name</th>
                          <th class="text-center">Gender</th>
                          <th class="text-center">Country</th>
                          <th class="text-center">State</th>
                          <th class="text-center">Cities</th>
                          <th class="text-center">Pin</th>
                          <th class="text-center">Phone</th>
                          <th class="text-center">Address</th>
                          <th class="text-center">Image</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="consumers.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                        <?php
                        for ($i=1; $i<=$total_pages; $i++) {
                        ?>
                          <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="consumers.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                        }
                        ?>
                          <li class="page-item <?php if($page==$total_pages){ echo "disabled";} ?>"><a class="page-link" href="consumers.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
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
  <?php include "js/script.php"; ?>
</body>
</html>