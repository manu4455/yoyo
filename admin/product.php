<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
if(isset($_GET['edit'])){
  $ids=$_GET['edit'];
  $page=$_GET['page'];
  $edit=$db->query("SELECT * FROM products WHERE product_id=$ids");
  $get_data=$edit->fetch_assoc();
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
                <div class="dropdown-menu rounded-0">
                  <a href="product.php"  class="dropdown-item bg-primary text-light"><i class="fa fa-plus"></i> Add Product</a>
                  <a href="product_summary.php " class="dropdown-item"><i class="fa fa-list"></i> Product Summary</a>
                </div>
              </div>
              <?php
              if(isset($_GET['edit'])){
               ?>
                <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-edit"></i> Edit Product</a>
                <?php
              }else{
                ?>
                <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-plus"></i> Add Product</a>
                <?php 
              }
              ?>
            </div>
          </div>
            <section class="main mt-2">
              <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                          <!-- general form elements -->
                          <div class="card">                    
                        <form class="" method="POST" action='<?php if(isset($_GET['edit'])){echo "edit.php";}else{ echo "add.php";} ?>' enctype="multipart/form-data">
                          <div class="card-body">
                            <div class="row">
                               <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                            <?php
                            function getcategory($parent_id=0 , $name = ''){
                              global $db;
                              $category = $db->query("SELECT * FROM category WHERE parent_id = $parent_id ORDER BY category_name ASC");
                              if($category->num_rows > 0){
                                while($row = $category->fetch_assoc()){
                                ?>
                                  <option value="<?php echo $rid=$row['cat_id'];?>"  <?php if(isset($_GET['edit'])){ $d=$_GET['p_id']; if($rid==$d){ echo "selected";}}?>><?php echo $name.$row['category_name']; ?></option>
                                  <?php
                                  $sub=$row['category_name'];
                                  getcategory($row['cat_id'], $name.$sub." | ");
                                }
                              }
                            }
                            ?>
                            <div class="form-group">
                              <label for="sel1">Category *</label>
                                <select class="form-control rounded" id="sel1" name="category" required="">
                                  <option value="" >Select Category</option>
                                  <?php getcategory(); ?>
                                </select>
                            </div>
                          </div>
                          <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label for="sel1">Brand *</label>
                            <select class="form-control rounded" id="sel1" name="brand" required="">
                              <?php
                              $brand = $db->query("SELECT * FROM brand ORDER BY brand_name ASC");
                              if($brand->num_rows > 0){
                                ?><option value="">Select Brand</option><?php
                                while($row_brand = $brand->fetch_assoc()){
                                ?>
                                  <option value="<?php echo $rid=$row_brand['brand_id'];?>"  <?php if(isset($_GET['edit'])){ $get_brand=$_GET['brand']; if($rid==$get_brand){ echo "selected";}}?>><?php echo $row_brand['brand_name']; ?></option>
                                  <?php
                                }
                              }
                              else{
                                ?>
                                  <option value="" disabled>Select Brand</option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label>Name *</label> <span class="text-danger"><?php if (isset($_SESSION['product_name'])) {echo  $_SESSION['product_name']; unset($_SESSION['product_name']);} ?></span>
                            <input type="text" name="edit" value="<?php if(isset($_GET['edit'])){ echo $d=$_GET['edit']; }?>" hidden>
                            <input type="text" name="page" value="<?php if(isset($_GET['page'])){ echo $d=$_GET['page']; }?>" hidden>
                            <input type="text" name="p_id" value="<?php if(isset($_GET['p_id'])){ echo $d=$_GET['p_id']; }?>" hidden>
                            <input type="text" class="form-control" name="name" required="" placeholder="Name of product" value="<?php if(isset($_GET['edit'])){ echo $get_data['product_name']; }?>">
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label>Image </label> <span class="text-danger"><?php if (isset($_SESSION['image'])) {echo  $_SESSION['image']; unset($_SESSION['image']);} ?></span>
                            <input type="text" name="default_image" value="<?php if(isset($_GET['edit'])){ echo $get_data['images']; }?>" hidden>
                            <input type="file"  accept="image/*" class="form-control rounded" name="image[]" id="file"  onchange="loadFile(event)" multiple><span><img id="output" class="rounded mt-1" src="../images/items/<?php if(isset($_GET['edit'])){ echo $get_data['images']; }else{ echo 'no.jpeg';} ?>" width="80" height="60" / alt="Multiple image"></span>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                          <label>Stock *</label>                            
                            <table class="table table_stock">                              
                              <tbody class="stock">
                                <tr id="stock1">
                                <?php
                                if(!isset($_GET['edit'])){
                                  ?>
                                  <td><input type="number" class="form-control" name="stock[]" <?php if(!isset($_GET['edit'])){echo "required";} ?> placeholder="Add Stock"></td>
                                  <?php
                                  } 
                                  ?>
                                  <td><a href="javascript:void(0);" class="add_feild btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></td>                              
                                </tr>
                                <?php
                                if(isset($_GET['edit'])){
                                $stock=$get_data['in_stock'];
                                $get_stock=explode(',',$stock);
                                $count_stock=count($get_stock);
                                  for ($i=0; $i < $count_stock ; $i++) { 
                                ?>
                                <tr id="stocks<?php echo $i; ?>">
                                <td><input type="number" class="form-control" name="stock[]" required="" value="<?php echo $get_stock[$i]; ?>" placeholder="Add Stock"></td>
                                <td><a href="#stocks<?php echo $i; ?>" class="feild_remove btn btn-danger" title="Add field"><i class="fa fa-times"></i></a></td>                              
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
                            <label>Size *</label>
                            <table class="table table_size">                              
                              <tbody class="size">                              
                                <tr id="size1">
                                <?php
                                if(!isset($_GET['edit'])){
                                  ?>
                                  <td><input type="number" class="form-control" name="size[]" <?php if(!isset($_GET['edit'])){echo "required";} ?> placeholder="Add Size"></td>
                                 <?php
                                }
                                ?> 
                                  <td><a href="javascript:void(0);" class="add_feild btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></td>                          
                                </tr>
                                <?php
                                if(isset($_GET['edit'])){
                                $size=$get_data['product_size'];
                                $get_size=explode(',',$size);
                                $count_size=count($get_size);
                                  for ($i=0; $i < $count_size ; $i++) { 
                                ?>
                                <tr id="sizes<?php echo $i; ?>">                               
                                  <td><input type="number" class="form-control" name="size[]" required="" value="<?php echo $get_size[$i]; ?>" placeholder="Add Size"></td>
                                  <td><a href="#sizes<?php echo $i; ?>" class="feild_remove btn btn-danger" title="Add field"><i class="fa fa-times"></i></a></td>                              
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
                          <label>Price(curr) *</label> <span class="text-danger"><?php if (isset($_SESSION['color'])) {echo  $_SESSION['color']; unset($_SESSION['color']);} ?></span>                           
                            <table class="table table_price">                              
                              <tbody class="price">
                                <tr id="price1">
                                <?php
                                if(!isset($_GET['edit'])){
                                  ?>
                                  <td><input type="number" class="form-control" name="newprice[]" <?php if(!isset($_GET['edit'])){echo "required";} ?> placeholder="Add Price"></td>
                                <?php } ?> 
                                  <td><a href="javascript:void(0);" class="add_feild btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></td>                              
                                </tr>
                                <?php
                                if(isset($_GET['edit'])){
                                $price=$get_data['new_price'];
                                $get_price=explode(',',$price);
                                $count_price=count($get_price);
                                  for ($i=0; $i < $count_price ; $i++) { 
                                ?>
                                <tr id="prices<?php echo $i; ?>">
                                  <td><input type="number" class="form-control" name="newprice[]" required="" value="<?php echo $get_price[$i]; ?>" placeholder="Add Price"></td>
                                  <td><a href="#prices<?php echo $i; ?>" class="feild_remove btn btn-danger" title="Add field"><i class="fa fa-times"></i></a></td>                              
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
                        if(isset($_GET['edit'])){?>      
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                          <label>Price(prev) *</label>                            
                            <table class="table table_oldprice">                              
                              <tbody class="oldprice">
                                <tr id="oldprice1">                              
                                  <td><a href="javascript:void(0);" class="add_feild btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></td>                              
                                </tr>
                                <?php
                                for ($i=0; $i < $count_price ; $i++) { 
                                  ?>
                                  <tr id="oldprices<?php echo $i; ?>">
                                    <td><input type="number" class="form-control" name="oldprice[]"  value="<?php echo $get_price[$i]; ?>" placeholder="Add Price"></td>
                                    <td><a href="#oldprices<?php echo $i; ?>" class="feild_remove btn btn-danger" title="Add field"><i class="fa fa-times"></i></a></td>                              
                                  </tr>
                                    <?php                                 
                                  }
                                  ?>                                   
                              </tbody>
                            </table> 
                          </div>
                        </div>
                        <?php } ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                          <div class="form-group">
                            <label>Color *</label>                        
                            <table class="table table_color">                              
                              <tbody class="color">
                                <tr id="color1">
                                <?php
                                if(!isset($_GET['edit'])){
                                  ?>
                                  <td><input type="text" class="form-control" name="color[]" <?php if(!isset($_GET['edit'])){echo "required";} ?> placeholder="Add Color"></td>
                                <?php } ?> 
                                  <td><a href="javascript:void(0);" class="add_color btn btn-primary" title="Add field"><i class="fa fa-plus"></i></a></td>                              
                                </tr>
                                <?php
                                if(isset($_GET['edit'])){
                                $color=$get_data['color'];
                                $get_color=explode(',',$color);
                                $count_color=count($get_color);
                                for ($i=0; $i < $count_color ; $i++) { 
                                ?>
                                <tr id="colors<?php echo $i; ?>">
                                  <td><input type="text" class="form-control" name="color[]" required="" value="<?php echo $get_color[$i]; ?>" placeholder="Add Color"></td>
                                  <td><a href="#colors<?php echo $i; ?>" class="feild_color btn btn-danger" title="Add field"><i class="fa fa-times"></i></a></td>                              
                                </tr>
                                  <?php   
                                  }                              
                                }
                                ?>                                  
                              </tbody>
                            </table>  
                          </div>
                        </div>                     
            
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                          <div class="form-group">
                            <label>Description *</label>
                            <textarea class="form-control " rows="10" name="description" required=""><?php if(isset($_GET['edit'])){ echo $get_data['product_description'];} ?></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                       <div class="card-footer">
                           <?php
                           if(isset($_GET['edit'])){
                            ?>
                            <button type="submit" class="btn btn-secondary" name="edit_product"><i class="fa fa-upload"></i> Edit Product</button> 
                            <?php
                           }
                           else{
                            ?>
                            <button type="submit" class="btn btn-secondary " name="add_product"><i class="fa fa-plus"></i> Add Product</button>
                            <?php
                            if (isset($_SESSION['message'])) {
                              echo  $_SESSION['message']; 
                              if ($_SESSION['message']=='<span class="text-success">Product added successfully</span>') {                                    
                                unset($_SESSION['message']);
                                ?>
                                <script>
                                  setTimeout(function(){
                                    window.location.href="product_summary.php";
                                  }, 1000);
                                </script>
                                <?php
                                }
                                else{
                                  unset($_SESSION['message']);
                                }
                              }
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