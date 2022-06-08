<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
if(isset($_GET['view'])){
  $ids=$_GET['view'];
  $edit="SELECT * FROM products INNER JOIN brand ON products.brands = brand.brand_id INNER JOIN category ON products.categorys = category.cat_id  WHERE products.product_id=$ids";
  $edit_query=mysqli_query($db, $edit);
  $get_data=mysqli_fetch_assoc($edit_query);
}
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
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
                <div class="dropdown-menu bg-primary rounded-0">
                  <a href="product.php"  class="dropdown-item bg-success"><i class="fa fa-plus"></i> Add Product</a>
                  <a href="product_summary.php " class="dropdown-item"><i class="fa fa-list"></i> Product Summary</a>
                </div>
              </div>      
            </div>
          </div>
            <section class="main mt-2">
              <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                          <!-- general form elements -->
                          <div class="card">                    
                        <form class="" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                              <div class="form-group">
                              <label for="sel1">Category</label>
                              <table>
                                <tr class="bg-info text-light rounded"><td class="p-2"><?php echo $get_data['category_name']; ?></td></tr>
                              </table>                                
                                                              
                            </div>
                          </div>
                          <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label for="sel1">Brand </label>
                            <table>
                              <tr class="bg-info text-light rounded"><td class="p-2"><?php echo $get_data['brand_name']; ?></td></tr>
                            </table>
                           
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label>Name </label>
                            <table>
                              <tr class="bg-info text-light rounded"><td class="p-2"><?php echo $get_data['product_name']; ?></td></tr>
                            </table>             
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label>Color </label>                        
                            <table class="table table_color">                              
                              <tbody class="color">
                                <?php
                                if(isset($_GET['view'])){
                                $color=$get_data['color'];
                                $get_color=explode(',',$color);
                                $count_color=count($get_color);                                 
                                ?>
                                <tr class="rounded bg-info text-light row">
                                <?php
                                for ($i=0; $i < $count_color ; $i++) {?>
                                  <td class=" border text-center p-2 col-3"><?php echo $get_color[$i]; ?></td>
                                  <?php   
                                  }   
                                  ?>
                                </tr>
                                  <?php                           
                                }
                                ?>                                  
                              </tbody>
                            </table>  
                          </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                          <div class="form-group">
                            <label>Image </label>
                            <table class="table ">                              
                              <tbody >
                                <?php
                                if(isset($_GET['view'])){
                                $image=$get_data['images'];
                                $get_image=explode(',',$image);
                                $count_image=count($get_image);                                 
                                ?>
                                <tr class="rounded">
                                <?php
                                for ($i=0; $i < $count_image ; $i++) {?>
                                  <td class="border bg-info p-2" height="50" weidth="50"><img src="../images/items/<?php echo $get_image[$i]; ?>" class="image-fluid" alt=""></td>
                                  <?php   
                                  }   
                                  ?>
                                </tr>
                                  <?php                           
                                }
                                ?>                                  
                              </tbody>
                            </table>  
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                          <label>Stock</label>                            
                            <table class="table table_stock">                              
                              <tbody class="stock">
                                <?php
                                if(isset($_GET['view'])){
                                $stock=$get_data['in_stock'];
                                $get_stock=explode(',',$stock);
                                $count_stock=count($get_stock);
                                  for ($i=0; $i < $count_stock ; $i++) { 
                                ?>
                                <tr id="stocks<?php echo $i; ?>">
                                  <td><input type="number" class="form-control" name="stock[]" required="" readonly value="<?php echo $get_stock[$i]; ?>" placeholder="Add Stock"></td>                                  
                                </tr>
                                  <?php                                 
                                  }
                                }
                                ?>                                
                              </tbody>
                            </table> 
                          </div>
                        </div>  
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group ">
                            <label>Size</label>
                            <table class="table table_size">                              
                              <tbody class="size">
                                <?php
                                if(isset($_GET['view'])){
                                $size=$get_data['product_size'];
                                $get_size=explode(',',$size);
                                $count_size=count($get_size);
                                  for ($i=0; $i < $count_size ; $i++) { 
                                ?>
                                <tr id="sizes<?php echo $i; ?>">
                                  <td><input type="number" class="form-control" name="size[]" required=""  readonly value="<?php echo $get_size[$i]; ?>" placeholder="Add Size"></td>                                 
                                </tr>
                                    <?php                                 
                                  }
                                }
                                ?>                                   
                              </tbody>
                            </table>                                                      
                          </div>
                        </div>                                             
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                          <label>Price(curr)</label>                            
                            <table class="table table_price">                              
                              <tbody class="price">
                                <?php
                                if(isset($_GET['view'])){
                                $price=$get_data['new_price'];
                                $get_price=explode(',',$price);
                                $count_price=count($get_price);
                                  for ($i=0; $i < $count_price ; $i++) { 
                                ?>
                                <tr id="prices<?php echo $i; ?>">
                                  <td><input type="number" class="form-control" name="newprice[]" required="" readonly value="<?php echo $get_price[$i]; ?>" placeholder="Add Price"></td>                                  
                                </tr>
                                  <?php
                                 }                                 
                                }
                                ?>                                     
                              </tbody>
                            </table> 
                          </div>
                        </div>
                        <?php
                        if(isset($_GET['view'])){?>      
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                          <label>Price(prev)</label>                            
                            <table class="table table_oldprice">                              
                              <tbody class="oldprice">
                                <?php
                                for ($i=0; $i < $count_price ; $i++) { 
                                  ?>
                                  <tr id="oldprices<?php echo $i; ?>">
                                    <td><input type="number" class="form-control" name="oldprice[]" readonly value="<?php echo $get_price[$i]; ?>" placeholder="Add Price"></td>                                    
                                  </tr>
                                    <?php                                 
                                  }
                                  ?>                                   
                              </tbody>
                            </table> 
                          </div>
                        </div>
                        <?php } ?>                                        
            
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                          <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control " rows="10" name="description" readonly><?php if(isset($_GET['view'])){ echo $get_data['product_description'];} ?></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                       <div class="card-footer">
                           <?php
                           if(isset($_GET['view'])){
                            ?>
                            <a href="product.php?edit=<?php  echo $_GET['view']; ?>&page=<?php echo $page; ?>&p_id=<?php echo $_GET['p_id']; ?>&brand=<?php echo $_GET['brand']; ?>"><i class="fa fa-edit btn btn-primary"> Edit</i> </a>
                            <?php
                           }
                        ?>
                       </div>   

                        </form>
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