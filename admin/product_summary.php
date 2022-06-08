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
$result_db = mysqli_query($db,"SELECT COUNT(product_id) FROM  products "); 
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
$result = mysqli_query($db,"SELECT * FROM products INNER JOIN brand ON products.brands = brand.brand_id INNER JOIN category ON products.categorys = category.cat_id ORDER BY products.product_id DESC LIMIT $start_from, $limit");
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
                      <button  class="btn btn-default navigator rounded-0 dropdown-toggle" data-toggle="dropdown"><i class="fa fa-product-hunt"></i> Product</button>
                      <div class="dropdown-menu rounded-0">
                        <a href="product.php"  class="dropdown-item"><i class="fa fa-plus"></i> Add Product</a>
                        <a href="product_summary.php " class="dropdown-item bg-primary text-light"><i class="fa fa-list"></i> Product Summary</a>
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
                                    <select class="form-control rounded" name="sort" id="productlimit">
                                      <option value="10"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==10){echo 'selected';}} ?>>10</option>
                                      <option value="20"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==20){echo 'selected';}} ?>>20</option>										
                                      <option value="50"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==50){echo 'selected';}} ?>>50</option>										
                                      <option value="100"<?php if(isset($_GET['limit'])){ if ($_GET['limit']==100){echo 'selected';}} ?>>100</option>	
                                    </select>
                                  </div>
                                </div>
                            </div>
                              <div class="box-body table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                                <table id="product" class="table table-bordered table-striped text-sentance">
                                    <thead>
                                    <tr>
                                      <th class="text-center">S.no</th>
                                       <th class="text-center">Brand</th>
                                       <th class="text-center">Category</th>
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Price(current)</th>
                                       <th class="text-center">Price(previous)</th>
                                       <th class="text-center">Size</th>
                                       <th class="text-center">Color</th>
                                       <th class="text-center">Stock</th>
                                       <th class="text-center">Image</th>
                                       <th class="text-center">Edit</th>                                       
                                       <th class="text-center">Delete</th>
                                       <th class="text-center">Items</th>
                                       <th class="text-center">Suggest</th>
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
                                    ?>
                                    <tr>
                                      <td class="text-center"><?php echo $num; ?></td>
                                      <td class="text-center"><?php echo $row['brand_name']; ?></td>
                                      <td class="text-center"><?php echo $row['category_name']; ?></td>
                                      <td class="text-center"><?php echo $row['product_name']; ?></td>
                                      <td class="text-center"><i class="fa fa-rupee text-primary"></i> <?php echo $row['new_price']; ?></td>
                                      <td class="text-left"><i class="fa fa-rupee text-primary"></i> <?php echo $row['old_price']; ?></td>
                                      <td class="text-left"><?php echo $row['product_size']; ?></td>
                                      <td class="text-center"><?php echo $row['color']; ?></td>
                                      <td class="text-center"><?php echo $row['in_stock']; ?></td>
                                      <td class="text-center img-sm"><img src="../images/items/<?php echo $get_image[$i]; ?>" alt="image" class="img-fluid img-sm" ></td>
                                      <td class="text-center"><a href="product.php?edit=<?php  echo $row['product_id']; ?>&page=<?php echo $page; ?>&p_id=<?php echo $row['categorys']; ?>&brand=<?php echo $row['brands']; ?>"><i class="fa fa-edit btn btn-primary"></i>
                                      </a></td>
                                      <td class="text-center"><a class="delete" data-toggle="modal" data-target="#delete<?php echo $row['product_id']; ?>"><i class="fa fa-trash btn btn-danger"></i>
                                      </a></td>
                                      <td class="text-center"><a href="items.php?view=<?php echo $row['product_id']; ?>&page=<?php echo $page; ?>&p_id=<?php echo $row['categorys']; ?>&brand=<?php echo $row['brands']; ?>"><i class="fa fa-eye btn btn-secondary"></i></a></td>
                                      <td class="text-center"><a  data-toggle="modal" data-target="#like<?php echo $row['product_id']; ?>"><i class="fa fa-thumbs-up btn btn-secondary"></i></a></td>
                                      <div class="modal fade" id="delete<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                              <input type="text" name="id" value="<?php echo $row['product_id']; ?>" hidden>
                                              <input type="text" name="page" value="<?php echo $page ?>" hidden>
                                              <h4 class="text-center text-dander">Your selected product will be deleted</h4>
                                              <h2 class="text-capitalize text-center"><?php echo $row['product_name']; ?></h2>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times " ></i></button>
                                            <button type="submit" name="delete_product" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal fade" id="like<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <form method="POST" action="add.php">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Processing....</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">                                
                                              <input type="text" name="id" value="<?php echo $row['product_id']; ?>" hidden>
                                              <input type="text" name="page" value="<?php echo $page ?>" hidden>
                                              <h4 class="text-center text-dander">This item will be displayed first to customer</h4>
                                              <h2 class="text-capitalize text-center"><?php echo $row['product_name']; ?></h2>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times " ></i></button>
                                            <button type="submit" name="suggest" class="btn btn-danger"><i class="fa fa-plus"></i></button>
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
                                    <tr>
                                      <td colspan="15">No Product Found !</td>
                                    </tr>
                                    <?php
                                  } 
                                  ?>
                                 </tbody>
                                    <tfoot>
                                    <tr>
                                      <th class="text-center">S.no</th>
                                       <th class="text-center">Brand</th>
                                       <th class="text-center">Category</th>
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Price(current)</th>
                                       <th class="text-center">Price(previous)</th>
                                       <th class="text-center">Size</th>
                                       <th class="text-center">Color</th>
                                       <th class="text-center">Stock</th>
                                       <th class="text-center">Image</th>
                                       <th class="text-center">Edit</th>                                       
                                       <th class="text-center">Delete</th>
                                       <th class="text-center">Items</th>
                                       <th class="text-center">Suggest</th>
                                     </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                  <!-- Pagination -->
                                  <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                      <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="product_summary.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                                      <?php
                                      for ($i=1; $i<=$total_pages; $i++) {
                                      ?>
                                        <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="product_summary.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                      <?php
                                      }
                                      ?>
                                        <li class="page-item <?php if($page==$total_pages){echo 'disabled';} ?>"><a class="page-link" href="product_summary.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
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