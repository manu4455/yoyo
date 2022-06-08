<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
//pagination
if(isset($_GET['limit'])){
  $limit = $_GET['limit']; 
}
else{
  $limit = 10; 
} 
$result_db = mysqli_query($db,"SELECT COUNT(brand_id) FROM  brand "); 
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
$result = mysqli_query($db,"SELECT * FROM brand ORDER BY brand_id DESC
   LIMIT $start_from, $limit");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin | Panel</title>
  <?php include 'link.php'; ?>
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
          <a href="index.php" class="btn btn-default navigator rounded-0"><i class="fa fa-home"></i> Home</a>
          <div class="dropdown drop">
            <button  class="btn btn-default navigator rounded-0 dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> Brand</button>
            <div class="dropdown-menu bg-primary rounded-0">
              <a href="brand.php"  class="dropdown-item"><i class="fa fa-plus"></i> Add Brand</a>
              <a href="brand_summary.php " class="dropdown-item bg-success"><i class="fa fa-list"></i> Brand Summary</a>
            </div>
          </div>
          <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-plus"></i> Summary</a>
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
                        <select class="form-control rounded" name="sort" id="brandlimit">
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
                          <th class="text-center">Brand Name</th>
                          <th class="text-center">Edit</th>
                          <th class="text-center">Delete</th>
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
                          <td><?php echo $row['brand_name']; ?></td>
                          <td><a href="brand.php?edit=<?php echo $row['brand_id']; ?>&page=<?php echo $page; ?>"><i class="fa fa-edit btn btn-primary"></i></a></td>
                          <td><a class="delete" data-toggle="modal" data-target="#delete<?php echo $row['brand_id']; ?>"><i class="fa fa-trash btn btn-danger"></i></a></td>
                          <!-- delete model -->
                          <div class="modal fade" id="delete<?php echo $row['brand_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form method="POST" action="delete.php">
                              <div class="modal-header">
                                <h5 class="modal-title">Processing....</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">                                
                                  <input type="text" name="id" value="<?php echo $row['brand_id']; ?>" hidden>
                                  <input type="text" name="page" value="<?php echo $page ?>" hidden>
                                  <h4 class="text-center text-dander">Do you want to delete brand!</h4>
                                  <h2 class="text-capitalize text-center"><?php echo $row['brand_name']; ?></h2>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times " ></i></button>
                                <button type="submit" name="delete_brand" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        </tr>
                          <?php
                          $num++;
                          }
                        }
                        else{
                          ?>
                          <tr class="text-left"><td colspan="4">No Brand Found !</td></tr>
                          <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="text-center">S.no</th>
                          <th class="text-center">Brand Name</th>
                          <th class="text-center">Edit</th>
                          <th class="text-center">Delete</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="brand_summary.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                        <?php
                        for ($i=1; $i<=$total_pages; $i++) {
                        ?>
                          <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="brand_summary.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                        }
                        ?>
                          <li class="page-item <?php if($page==$total_pages){ echo "disabled";} ?>"><a class="page-link" href="brand_summary.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
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
<?php $database->close(); ?>