<?php
session_start();
if(!isset($_SESSION['id'])|| ($_SESSION['id']=='') && ($_SESSION['email'])|| ($_SESSION['email']=='') && ($_SESSION['name'])|| ($_SESSION['name']=='') )
{ 
	$_SESSION['login']="login";
	header("location:index.php");
}
else{
include "dbconfig/dbconfig.php";
$db=$database->open();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Sneekers | My Cart</title>
	<?php include "link.php"; ?>
</head>
<body>
<div class="loader"></div>
<!-- header section -->
<?php include "header.php"; ?>
<!-- Section Cart -->
<section class="section-content padding-y mt-1">
	<div class="container-fluid">
		<div class="row">
			<main class="col-12">
			<div id="cart"></div>
			<div id="abs" class="text-dark"></div>
				<div class="card border">
					<header class="card-header card-background text-light text-bold pl-1"><i class="fa fa-shopping-cart"></i> My Cart</header>
					<div id="cart_item" class="mt-1 pl-1 pr-1">						
					<?php
					if (isset($_SESSION['id'])) { 
						$customer = $_SESSION['id'];
						$check_cart = $db -> query("SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id INNER JOIN category ON products.categorys=category.cat_id WHERE cart.customer_id=$customer");    
						if($check_cart -> num_rows >=1){
							$total_amount="";
							while($cart = $check_cart -> fetch_assoc()){
							$image=$cart['images'];
							$get_image=explode(',',$image);				
							$size=$cart['product_size'];
							$get_size=explode(',',$size);									
							$color=$cart['cart_color'];	
							$amount=$cart['new_price'];	
							$get_price=explode(',',$amount);			
							$size_id=$cart['size_id'];
							$i=0;                            
						?>
						<div class=" row no-gutters border mb-1" id="<?php echo $cart['cart_id']; ?>">
							<aside class="col-4 col-sm-4 col-md-3  col-lg-3  text-center text-sm-left info-left border-right  pl-2 pr-2 pt-2 pb-3">
								<div class="img-lg img-sm ">
									<img src="images/items/<?php echo $get_image[$i]; ?>" class="img-fluid" >
								<div>
							</aside> <!-- col.// -->
							<div class="col-8 col-sm-8 col-md-6 col-lg-4 p-2">
								<div class="info-main">
									<a  class="h5 title text-capitalize font-weight-bold text-dark"><?php echo $cart['product_name'];  ?></a>
								</div> <!-- info-main.// -->
								<figcaption class="info col-12 text-capitalize d-flex pl-0">
									<p class="text-muted small text-capitelize">Size: <?php echo $get_size[$size_id];  ?>, Color: <?php echo $color;  ?>, <br> Brand:  <?php echo $cart['brand_name'];  ?></p>
								</figcaption>
							</div> <!-- col.// -->
							<aside class="col-12 col-sm-12  col-md-3 col-lg-2 p-2 border-left">
								<div class="info-aside">
									<select class="form-control quantity" id="q<?php echo $cart['cart_id']; ?>" name="quantity">
										<option value="1"<?php if(isset($cart['quantity'])){ if ($cart['quantity']==1){echo 'selected';}} ?>>1</option>
										<option value="2"<?php if(isset($cart['quantity'])){ if ($cart['quantity']==2){echo 'selected';}} ?>>2</option>										
										<option value="3"<?php if(isset($cart['quantity'])){ if ($cart['quantity']==3){echo 'selected';}} ?>>3</option>										
										<option value="4"<?php if(isset($cart['quantity'])){ if ($cart['quantity']==4){echo 'selected';}} ?>>4</option>																				
									</select> 
								</div> <!-- info-aside.// -->
							</aside>
							<div class="col-8 col-sm-8 col-md-6 col-lg-2 p-2 border-top text-left">
								<div class="price-wrap cart-price"> 
									<var class="price"><i class="fa fa-rupee"></i> <?php echo $get_price[$size_id]; ?><small class="text-muted">/per item</small>  </var>									
								</div> <!-- price-wrap .// -->
							</div>
							<div class="col-4 col-sm-4 col-md-6 col-lg-1 p-2 border-top text-right">
								<a title="Remove item"  href="#<?php echo $cart['cart_id']; ?>" class="btn btn-light cart" data-toggle="tooltip"> <i class="fa fa-times"></i></a> 
							</div>
						</div>
						<?php 
						} 
						?>
						<div class="row mt-2 no-gutters border-top mb-2 border-bottom pt-3 pb-3 pr-2 pl-2 cart_total">
							
						</div>
						<?php
						}else{
							?>
							<div class="col-12 no-gutters border-top border-bottom p-3 mb-2 mt-2">
								<p  class="text-center text-danger"><i class="pe-7s-cart" style="font-size: 40px;"></i><br/> No cart item found, Please add items to cart!</p>
							</div>
							<?php
							}
						} ?>
						<div class="row no-gutters pb-2">
							<div  class="text-left col-6">
								<?php if($check_cart -> num_rows >=1){?>
								<form method="POST" action="action.php" >
									<button  type="submit" class="btn btn-primary float-left cart_purchase_button"  name="cart_purchase" > Order now <i class="fa fa-chevron-right"></i> </button>
								</form>
								<?php }?>
							</div>
							<div  class="text-right col-6">	
								<a href="product.php" class="btn btn-light float-right cart_purchase_button" style="white-space: nowrap;"> <i class="fa fa-chevron-left"></i> Continue shopping </a>
							</div>
						</div>							
					</div>	
				</div> <!-- card.// -->
			</main> <!-- col.// -->
		</div>
	</div> <!-- container .//  -->
</section>
<!-- Section Cart end -->
<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
<?php $db=$database->close(); }?>