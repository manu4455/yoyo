<?php
  //Session start
  session_start();
  // Include database connection
  include 'dbconfig/dbconfig.php';
  $db = $database->open();
  //get data for update 
  if(isset($_GET['edit'])){
    $ids=$_GET['edit'];
    $page=$_GET['page'];
    $edit=$db->query("SELECT * FROM category WHERE cat_id=$ids");
    $get_data=$edit->fetch_assoc();   
  }  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                <a href="category.php"  class="dropdown-item bg-success"><i class="fa fa-plus"></i> Add Category</a>
                <a href="category_summary.php " class="dropdown-item"><i class="fa fa-list"></i> Category Summary</a>
              </div>
            </div>
            <?php
              if(isset($_GET['edit'])){
            ?>
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-edit"></i> Edit Category</a>
            <?php
            }
            else{
              ?>
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-plus"></i> Add Category</a>
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
                      <div class="col-md-4">
                        <?php
                        function getcategory($parent_id=0 , $name = ''){
                          global $db;
                          $query = $db->query("SELECT * FROM category WHERE parent_id = $parent_id ORDER BY category_name ASC");
                          if($query->num_rows > 0){
                            while($row = $query->fetch_assoc()){
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
                          <label for="sel1">Category</label>
                            <select class="form-control rounded" id="sel1" name="category">
                              <option value="">Select Category</option>
                              <?php getcategory(); ?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="sel1">Category Name *</label> <span class="text-danger"><?php if (isset($_SESSION['cat_name'])) {echo  $_SESSION['cat_name']; unset($_SESSION['cat_name']);} ?></span>                          
                          <input type="text" name="edit" value="<?php if(isset($_GET['edit'])){ echo $d=$_GET['edit']; }?>" hidden>
                          <input type="text" name="page" value="<?php echo $page; ?>" hidden>
                          <input type="text" name="p_id" value="<?php if(isset($_GET['p_id'])){ echo $_GET['p_id']; } ?>" hidden>
                          <input type="text" class="form-control rounded" value="<?php if(isset($get_data['category_name'])){ echo $get_data['category_name']; } ?>" id="text" placeholder="Category Name" name="catname" required="">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="sel1">Category image </label> <span class="text-danger"><?php if (isset($_SESSION['image'])) {echo  $_SESSION['image']; unset($_SESSION['image']);} ?></span>                          
                          <input type="text" name="default_image" value="<?php if(isset($_GET['edit'])){ echo $get_data['image']; }?>" hidden>
                          <input type="file"  accept="image/*" class="form-control rounded" name="image" id="file"  onchange="loadFile(event)" ><span><img id="output" class="rounded mt-1" src="../images/category/<?php if(isset($get_data['image'])){ echo $get_data['image']; }else{ echo 'no.jpeg';} ?>" width="80" height="60" /></span>
                        </div>
                      </div>
                    </div>
                    </div>
                  <div class="card-footer">
                    <?php
                    if(isset($_GET['edit'])){
                      ?>
                      <button type="submit" class="btn btn-secondary" name="edit_category"><i class="fa fa-upload"></i> Edit Category</button>
                      <?php
                    }
                    else{
                      ?>
                      <button type="submit" class="btn btn-secondary " name="add_category"><i class="fa fa-plus"></i> Add Category</button>
                      <?php
                      if (isset($_SESSION['message'])) {
                        echo  $_SESSION['message']; 
                        if ($_SESSION['message']=='<span class="text-success">Category added successfully</span>') {                                    
                          ?>
                          <script>
                            setTimeout(function(){
                              window.location.href="category_summary.php";
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
<?php $db = $database->close();?>