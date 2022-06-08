<?php
session_start();
if(!isset($_SESSION['id'])|| ($_SESSION['id']=='') && ($_SESSION['email'])|| ($_SESSION['email']=='') && ($_SESSION['name'])|| ($_SESSION['name']=='') )
{ 
	$_SESSION['login']="login";
	header("location:index.php");
}
else{
$id = $_SESSION['id'];
include "dbconfig/dbconfig.php";
$db=$database->open();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Sneekers | My Wishlist</title>
	<!-- Bootstrap cdn and custom css -->
	<?php include "link.php"; ?>
</head>
<body>
<!-- header section -->
<?php include "header.php"; ?>
<section class="section-content padding-y mt-1">
	<div class="container-fluid">
		<div class="row">
			<main class="col-md-12">
				<div class="card border ">
					<header class="card-header card-background text-light text-bold pl-1"><i class="fa fa-heart-o"></i> My Wishlist</header>
					<div class=" card-body row no-gutters  mt-1 pl-1">
                    <?php
					$get_product=$db->query("SELECT * FROM wish INNER JOIN products ON wish.item_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id WHERE wish.customer_id=$id ORDER BY wish.wish_id DESC");
                    if($get_product->num_rows > 0){            
                        while($items=$get_product->fetch_assoc()){
                        $item = $items['product_id']; 
                        $item_id = base64_encode($item);
                        $category = $items['categorys'];        
                        $item_in = base64_encode($category);
                        ?>
                            <div class="col-md-3 col-sm-4 col-6 col-lg-2 mb-1">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                                        <?php
                                        $image=$items['images'];
                                        $get_image=explode(',',$image);
                                        $count_image=count($get_image);
                                        $i=0;                                 
                                        if ($count_image > 1) {
                                            echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                                            echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                                        }
                                        else{
                                            echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                                        }
                                        ?> 
                                        </a>                                       
                                        <span class="product-new-label">Sale</span>                                        
                                        <?php
                                        $price=$items['new_price'];
                                        $old=$items['old_price'];
                                        $new_price=explode(',',$price);
                                        $old_price=explode(',',$old);
                                        if ($old_price[$i] > $new_price[$i]) {
                                            $inc=$old_price[$i]-$new_price[$i];
                                            $increase=$inc/$old_price[$i]*100;
                                            echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                                        }
                                        ?>
                                        
                                    </div>
                                    <div class="product-content pl-1 pr-1 text-left">
                                        <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                                        <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                                        <div class="price  text-left">
                                            <?php 
                                            echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                                            if ($old_price[$i] > $new_price[$i]) {
                                                echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                                            }
                                            ?>
                                        </div>
                                        <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
										
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            </ul>
                       
                            <?php
                        }
                        ?>					
					</div>
				</div>
			</main>
		</div>
	</div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
<?php 
}
$db=$database->close(); 
?>