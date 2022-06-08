<?php
session_start();
include "dbconfig/dbconfig.php";
$db=$database->open();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Sneakers | Home</title>	
	<!-- Bootstrap cdn and custom css -->
	<?php include "link.php"; ?>
</head>
    <body>
        <div class="loader"></div>
        <!-- header section -->
        <?php include "header.php"; ?>
        <div class="container-fluid">
            <section class="section-main mt-1">
                <main class="card rounded-0  parent-image">
                <?php 
                if (isset($_GET['category'])) {
                    $cat = $_GET['category'];
                    $id = base64_decode($cat); 
                    $get_category=$db->query("SELECT * FROM category WHERE cat_id=$id");
                    $row=$get_category->fetch_assoc();
                    // echo '<img src="images/category/'. $row['image'].'" class="img-fluid" >';
                    echo '<div class="parent-name text-uppercase">'. $row['category_name']. '</div>';
                }?>
                
                </main>
            </section>
            <section class="section-main mt-1">
                <main class="card rounded-0">
                    <div class="card-body">
                        <div class="card-header c-header d-flex pb-2 pl-0 pr-0 pt-0 ">
                            <?php
                            $id=0;
                            $get_category=$db->query("SELECT * FROM category WHERE parent_id=$id");
                            if($get_category->num_rows > 0){
                                while($row=$get_category->fetch_assoc()){ 
                            ?>
                                <li class="nav-item  px-1 text-capitalize ">
                                    <a class="nav-link" href="?category=<?php $cat_id=$row['cat_id']; echo base64_encode($cat_id); ?>"><span class="<?php if (isset($_GET['category'])) {$cat = $_GET['category'];$id = base64_decode($cat); if($id == $row['cat_id']){echo "line";}}?>"><?php echo $row['category_name']; ?> </span></a>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    <div class="row justify-cotent-center">
                        <?php
                        function sublink($ids){
                            global $db;
                            $get_category=$db->query("SELECT * FROM category WHERE parent_id=$ids ORDER BY cat_id DESC");
                            if($get_category->num_rows > 0){
                                while($row=$get_category->fetch_assoc()){
                                    ?>
                                    <div class="col-4 col-sm-4 col-lg-2 category-row">
                                        <a href="category.php?category=<?php $cat_id=$row['cat_id']; echo base64_encode($cat_id); ?>">
                                            <div class="card category-image">
                                                <img src="images/category/<?php echo $row['image']; ?>" alt="image" class="rounded img-fluid">
                                                <div class="category-name bg-secondary text-light text-capitalize"><?php echo $row['category_name']; ?></div>
                                            </div>
                                        </a>
                                        </div>										 
                                    <?php
                                    sublink($row['cat_id']);
                                }
                            }
                        }
                        if (isset($_GET['category'])) {
                            $cat = $_GET['category'];
                            $id = base64_decode($cat);
                            sublink($id);
                        }
						?>
					</div>
                    </div>
                </main>
            </section>
        </div>
        <!-- Footer-->
        <?php include 'footer.php'; ?>
	<!-- Footer end-->
	</body>
</html>