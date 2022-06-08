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
$result_db = mysqli_query($db,"SELECT COUNT(cat_id) FROM  category "); 
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
$result = mysqli_query($db,"SELECT * FROM category WHERE parent_id=$parent
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
              <button  class="btn btn-default navigator rounded-0 dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> Category</button>
              <div class="dropdown-menu bg-primary rounded-0">
                <a href="category.php"  class="dropdown-item"><i class="fa fa-plus"></i> Add Category</a>
                <a href="category_summary.php " class="dropdown-item  bg-success"><i class="fa fa-list"></i> Category Summary</a>
              </div>
            </div>
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-list"></i> Summary</a>
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
                        <input type="text" name="search" id="search" class="form-control rounded">
                      </div>
                      <div class="col-6">
                        <label>Sort</label>
                        <select class="form-control rounded" name="sort" id="categorylimit">
                          <option value="10"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==10){echo 'selected';}} ?>>10</option>
                          <option value="20"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==20){echo 'selected';}} ?>>20</option>										
                          <option value="50"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==50){echo 'selected';}} ?>>50</option>										
                          <option value="100"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==100){echo 'selected';}} ?>>100</option>	
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="card-body mt-1 table-responive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">S.no</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Sub_Category</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
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
                            <td><?php echo $row['category_name'];?></td>
                            <td class="text-center">
                              <?php 
                                $parent_id=$row['cat_id'];
                                $count_sub="SELECT cat_id FROM category WHERE parent_id=$parent_id";
                                $sub_query=mysqli_query($db, $count_sub);
                                $count=mysqli_num_rows($sub_query);
                                if($count==0){
                                }
                                else{
                                  ?>
                                  <a href="category_summary.php?parent=<?php  echo $parent_id; ?>" class="btn btn-success sub"> 
                                  <?php
                                }
                              ?>                 
                              <?php echo $count; ?></a>
                            </td>
                            <td class="text-center img-sm"><img src="../images/category/<?php echo $row['image']; ?>" alt="image" class="img-fluid img-sm"></td>
                            <td class="text-center">
                              <?php
                                $product="SELECT * FROM products WHERE categorys=$parent_id";
                                $product_query=mysqli_query($db,$product);
                                $product_count=mysqli_num_rows($product_query);
                                if($product_count==0){
                                }
                                else{
                                  ?>
                                  <a href="product_summary.php?showproduct=<?php  echo $parent_id; ?>" class="btn btn-secondary"> 
                                  <?php
                                }
                              ?>                 
                              <?php echo $product_count; ?></a>
                            </td>
                            <td class="text-center"><a href="category.php?edit=<?php echo $row['cat_id']; ?>&p_id=<?php echo $row['parent_id']; ?>&page=<?php echo $page; ?>"><i class="fa fa-edit btn btn-primary"></i>
                            </a></td>
                            <td class="text-center"><a class="delete" data-toggle="modal" data-target="#delete<?php echo $row['cat_id']; ?>"><i class="fa fa-trash btn btn-danger"></i>
                            </a></td>
                            <div class="modal fade" id="delete<?php echo $row['cat_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                  <input type="text" name="id" value="<?php echo $row['cat_id']; ?>" hidden>
                                  <input type="text" name="page" value="<?php echo $page ?>" hidden>
                                  <h4 class="text-center text-dander">Your selected category, sub category and its product will be deleted</h4>
                                  <h2 class="text-capitalize text-center"><?php echo $row['category_name']; ?></h2>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times " ></i></button>
                                <button type="submit" name="delete_category" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
                        <tr class="text-left">
                          <td colspan="7">No Category Found !</td>
                        </tr>
                        <?php
                      } 
                      ?>
                      </tbody>
                        <tfoot>
                        <tr>
                          <th class="text-center">S.no</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Sub_Category</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Update</th>
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
                          <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="category_summary.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                          <?php
                          for ($i=1; $i<=$total_pages; $i++) {
                          ?>
                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="category_summary.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                          <?php
                          }
                          ?>
                            <li class="page-item <?php if($page==$total_pages){echo 'disabled';} ?>"><a class="page-link" href="category_summary.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
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
<?php $db = $database->open(); ?>