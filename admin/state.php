<?php
  //Session start
  session_start();
  // Include database connection
  include 'dbconfig/dbconfig.php';
  $db = $database->open();
  //get data for update 
  if(isset($_GET['edit'])){
    $ids=$_GET['edit'];
    $edit=$db->query("SELECT * FROM banner WHERE id=$ids");
    $get_data=$edit->fetch_assoc();
  }
  //pagination
  if(isset($_GET['limit'])){
    $limit = $_GET['limit']; 
  }
  else{
    $limit = 10; 
  }
$result_db = mysqli_query($db,"SELECT COUNT(states.id) FROM states INNER JOIN  country ON states.c_id=country.id WHERE country.status=1"); 
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
$result = mysqli_query($db,"SELECT states.id,states.state_name,states.status FROM states INNER JOIN country ON states.c_id=country.id WHERE country.status=1  LIMIT $start_from, $limit");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Panel</title>
    <?php include 'link.php'; ?>
    <script>
    $(document).ready(function() {
    $('.check').on('click', function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'action.php',
                data: 'statecheck=' + id,
                success: function(message) {
                    $('#message').html(message);
                }
            });
        }
    });
    $('.uncheck').on('click', function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        if (id) {
            $.ajax({
                type: 'POST',
                url: 'action.php',
                data: 'stateuncheck=' + id,
                success: function(message) {
                    $('#message').html(message);
                }
            });
        }
    });
   
});

    </script>
  </head>
  <body>
  <div class="loader"></div>
    <div class="wrapper">
      <!-- Sidebar  -->
      <?php include 'aside.php'; ?>
      <!-- Page Content  -->
      <div id="content">
      <?php include 'header.php'; ?>
        <div class="navigation col-12  bg-light justify-content-center justify-content-sm-left ">
          <div class="btn-group justify-content-center justify-content-sm-left">  
            <a href="dashboard.php" class="btn btn-default navigator rounded-0"><i class="fa fa-home"></i> Home</a>            
            
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-flag"></i> States</a>
           
          </div>
        </div>
        <section class="main mt-2">
          <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                <div id="message"></div>
                <div class="card">
                  <div class="card-header with-border">
                    <div class="row ">
                      <div class="col-6">
                        <label>Search</label>
                        <input type="text" name="search" id="search" class="form-control rounded">
                      </div>
                      <div class="col-6">
                        <label>Sort</label>
                        <select class="form-control rounded" name="sort" id="statelimit">
                          <option value="10"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==10){echo 'selected';}} ?>>10</option>
                          <option value="20"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==20){echo 'selected';}} ?>>20</option>										
                          <option value="50"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==50){echo 'selected';}} ?>>50</option>										
                          <option value="100"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==100){echo 'selected';}} ?>>100</option>
                          <option value="500"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==500){echo 'selected';}} ?>>500</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="card-body mt-1 table-responive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                    <table id="" class="table table-bordered table-striped w-100">
                        <thead>
                          <tr>
                            <th class="text-center">S.no</th>
                            <th class="text-center" width="70">State Name</th>
                            <th class="text-center" width="10">Enabled</th>
                            <th class="text-center" width="10">Disabled</th>
                          </tr>
                        </thead>
                        <tbody class="text-center" id="datatable">
                        <?php
                        $count_row=mysqli_num_rows($result);
                        if($count_row>=1){
                        $num=1;
                        while ($row=mysqli_fetch_assoc($result)) {
                          ?>
                          <tr>
                            <td class="text-center"><?php echo $num; ?></td>
                            <td><?php echo $row['state_name'];?></td> 
                             <td>
                                <label class="custom-control custom-checkbox">
									<input type="checkbox" id="<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>" class="custom-control-input check" <?php if ($row['status']==1){echo 'checked';} ?> >
									<div class="custom-control-label text-capitalize" ><?php if ($row['status']==1){echo '<i class="fa fa-check"></i>';}else{ echo '<i class="fa fa-times"></i>';} ?> </div>
								</label>
                              </td> 
                              <td>
                                <label class="custom-control custom-checkbox">
									<input type="checkbox" id="<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>" class="custom-control-input uncheck" <?php if ($row['status']==0){echo 'checked';} ?>>
                                    <div class="custom-control-label text-capitalize"><?php if ($row['status']==0){echo '<i class="fa fa-check"></i>';}else{ echo '<i class="fa fa-times"></i>';} ?> </div>
								</label>
                               </td> 
                          </tr>
                          <?php
                          $num++;
                        }
                      }
                      else{
                        ?>
                        <tr class="text-left">
                          <td colspan="4">No State Found !</td>
                        </tr>
                        <?php
                      } 
                      ?>
                      </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-center">S.no</th>
                            <th class="text-center"width="70">State Name</th>                          
                            <th class="text-center" width="10">Enable</th>
                            <th class="text-center" width="10">Disabled</th>
                         
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <!-- Pagination -->
                      <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                          <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="state.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                          <?php
                          for ($i=1; $i<=$total_pages; $i++) {
                          ?>
                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="state.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                          <?php
                          }
                          ?>
                            <li class="page-item <?php if($page==$total_pages){echo 'disabled';} ?>"><a class="page-link" href="state.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
                        </ul> 
                      </nav>
                    </div>
                </div>
                <!-- /.card -->

            </div>
          </div>
        </div>
      </section>
      <div class="line"></div>
    </div>
  </div>
  <div class="overlay"></div>
  <?php include "js/script.php"; ?>
</body>
</html>
<?php $db = $database->close(); ?>