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
$result_db = mysqli_query($db,"SELECT COUNT(id) FROM  banner "); 
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
$result = mysqli_query($db,"SELECT * FROM banner INNER JOIN category ON banner.cat_id=category.cat_id  LIMIT $start_from, $limit");
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
            <?php
              if(isset($_GET['edit'])){
            ?>
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-edit"></i> Edit Banner</a>
            <?php
            }
            else{
              ?>
            <a  class="btn btn-default navigator rounded-0 text-success"><i class="fa fa-plus"></i> Add Banner</a>
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
                      <div class="col-md-6">
                        <input type="text" name="edit" value="<?php if(isset($_GET['edit'])){ echo $get_data['id'];} ?>" hidden>
                        <input type="text" name="page" value="<?php echo $page; ?>" hidden>
                        <input type="text" name="p_id" value="<?php if(isset($_GET['p_id'])){ echo $_GET['p_id']; } ?>" hidden>
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
                          <label for="sel1">Category *</label>
                            <select class="form-control rounded" id="sel1" name="category" required="">
                              <option value="">Select Category</option>
                              <?php getcategory(); ?>
                            </select>
                        </div>
                      </div>                      
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel1">Banner image *</label> <span class="text-danger"><?php if (isset($_SESSION['image'])) {echo  $_SESSION['image']; unset($_SESSION['image']);} ?></span>
                          <input type="text" name="default_image" value="<?php if(isset($_GET['edit'])){ echo $get_data['images']; }?>" hidden>
                          <input type="file"  accept="image/*" class="form-control rounded" name="image" id="file"  onchange="loadFile(event)" required=""><span><img id="output" class="rounded mt-1" src="../images/banners/<?php if(isset($get_data['images'])){ echo $get_data['images']; }else{ echo 'no.jpeg';} ?>" width="80" height="60" /></span>
                        </div>
                      </div>
                    </div>
                    </div>
                  <div class="card-footer">
                    <?php
                    if(isset($_GET['edit'])){
                      ?>
                      <button type="submit" class="btn btn-secondary" name="edit_banner"><i class="fa fa-upload"></i> Edit Banner</button> 
                      <?php
                    }
                    else{
                      ?>
                      <button type="submit" class="btn btn-secondary " name="add_banner"><i class="fa fa-plus"></i> Add Banner</button> 
                      <?php
                      if (isset($_SESSION['message'])) {
                        echo  $_SESSION['message']; 
                        if ($_SESSION['message']=='<span class="text-success">Banner added successfully</span>') {                                    
                          unset($_SESSION['message']);
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
              <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }?>
                <div class="card">
                  <div class="card-header with-border">
                    <div class="row ">
                      <div class="col-6">
                        <label>Search</label>
                        <input type="text" name="search" id=" #myInput" class="form-control rounded">
                      </div>
                      <div class="col-6">
                        <label>Sort</label>
                        <select class="form-control rounded" name="sort" id="bannerlimit">
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
                            <th class="text-center">Image</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                          </tr>
                        </thead>
                        <tbody class="text-center" id="myTable">
                        <?php
                        $count_row=mysqli_num_rows($result);
                        if($count_row>=1){
                        $num=1;
                        while ($row=mysqli_fetch_assoc($result)) {
                          ?>
                          <tr>
                            <td class="text-center"><?php echo $num; ?></td>
                            <td><?php echo $row['category_name'];?></td>
                            
                            <td class="text-center" height="60" width="80"><img class="img-fluid" src="../images/banners/<?php echo $row['images'];  ?>" alt=""></td>
                            
                            <td class="text-center"><a href="banner.php?edit=<?php echo $row['id']; ?>&p_id=<?php echo $row['cat_id']; ?>&page=<?php echo $page; ?>"><i class="fa fa-edit btn btn-primary"></i>
                            </a></td>
                            <td class="text-center"><a  data-toggle="modal" data-target="#delete<?php echo $row['id']; ?>"><i class="fa fa-trash btn btn-danger"></i>
                            </a></td>
                            <div class="modal fade" id="delete<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                  <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                  <input type="text" name="page" value="<?php echo $page ?>" hidden>
                                  <h4 class="text-center text-dander">Banner image will be deleted</h4>
                                  <h2 class="text-capitalize text-center"><?php echo $row['category_name']; ?></h2>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times " ></i></button>
                                <button type="submit" name="delete_banner" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
                          <td colspan="5">No Banner Image Found !</td>
                        </tr>
                        <?php
                      } 
                      ?>
                      </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-center">S.no</th>
                            <th class="text-center">Category</th>                          
                            <th class="text-center">Image</th>
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
                          <li class="page-item <?php if($page==1){ echo "disabled";} ?>"><a class="page-link" href="banner.php?page=<?php $dec=1; $prev=$page-$dec; echo $prev; ?>" tabindex="-1" aria-disabled="true">Previous</a></li>
                          <?php
                          for ($i=1; $i<=$total_pages; $i++) {
                            if($page==$i-1){
                          ?>
                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="banner.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                            }
                            if($page==$i){
                            ?>
                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="banner.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                            }
                            if($page==$i+1){
                            ?>
                            <li class="page-item <?php if($page==$i){ echo 'active';} ?>"><a class="page-link" href="banner.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                            }
                          }
                          ?>
                          <li class="page-item <?php if($page==$total_pages){echo 'disabled';} ?>"><a class="page-link" href="banner.php?page=<?php $inc=1; $next=$page+$inc; echo $next; ?>">Next</a></li>
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