<?php
//Session start
session_start();
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
if(isset($_GET['edit'])){
  $ids=$_GET['edit'];
  $edit=$db->query("SELECT * FROM brand WHERE brand_id=$ids");
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
                      <button  class="btn btn-default navigator rounded-0 dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> Brand</button>
                      <div class="dropdown-menu bg-primary rounded-0">
                        <a href="brand.php"  class="dropdown-item bg-success"><i class="fa fa-plus"></i> Add Brand</a>
                        <a href="brand_summary.php " class="dropdown-item"><i class="fa fa-list"></i> Brand Summary</a>
                      </div>
                    </div>
                    <?php
                      if(isset($_GET['edit'])){
                    ?>
                    <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-edit"></i> Edit Brand</a>
                    <?php
                    }
                    else{
                      ?>
                    <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-plus"></i> Add Brand</a>
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
                          <div class="card">
                            <!-- form start -->
                            <form role="form" method="POST" action='<?php if(isset($_GET['edit'])){echo "edit.php";}else{ echo "add.php";} ?>'>
                              <div class="card-body">
                                <div class="form-group">
                                 <label>Brand Name *</label> <span class="text-danger"><?php if (isset($_SESSION['brand_name'])) {echo  $_SESSION['brand_name']; unset($_SESSION['brand_name']);} ?></span>
                                 <input type="text" name="edit" value="<?php if(isset($_GET['edit'])){ echo $d=$_GET['edit']; }?>" hidden>
                                 <input type="text" name="page" value="<?php if(isset($_GET['edit'])){ echo $page=$_GET['page']; }?>" hidden>
                                 <input type="text" class="form-control" value="<?php if(isset($get_data['brand_name'])){ echo $get_data['brand_name']; } ?>" placeholder="Enter Brand" name="brand">
                                </div>
                              </div>
                              <!-- /.card-body -->
                              <div class="card-footer">
                                
                                <?php
                                  if(isset($_GET['edit'])){
                                ?>
                                <button type="submit" class="btn btn-secondary" name="edit_brand"><i class="fa fa-edit"></i> Edit Brand</button>
                                <?php
                                }
                                else{
                                  ?>
                                  <button type="submit" class="btn btn-secondary " name="add_brand"><i class="fa fa-plus"></i> Add Brand</button>  
                                  <?php
                                  if (isset($_SESSION['message'])) {
                                    echo  $_SESSION['message']; 
                                    if ($_SESSION['message']=='<span class="text-success">Brand added successfully</span>') {                                    
                                      ?>
                                      <script>
                                        setTimeout(function(){
                                          window.location.href="brand_summary.php";
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
                          <!-- /.box -->
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
<?php $db = $database->close();?>