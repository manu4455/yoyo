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
	<title>Sneekers | Item Details</title>
	<?php include "link.php"; ?>
</head>
<body id="body">
<div class="loader"></div>
<!-- header section -->
<?php include "header.php"; ?>

<!-- function -->
<?php include "function.php"; ?>

<div class="container-fluid">

	<section class="section-content bg-white mt-4">
		<div class="row">
			<?php			
			if (isset($_GET['items'])) {
				$product = $_GET['items'];
				$product_in = $_GET['items_in'];
				$id = base64_decode($product);
				$get_product = $db->query("SELECT * FROM products INNER JOIN category ON products.categorys=category.cat_id INNER JOIN brand ON products.brands=brand.brand_id WHERE  products.product_id = $id");
				if($get_product->num_rows > 0){
					$items=$get_product->fetch_assoc();
					$item = $items['product_id'];
					$image =  $items['images'];
					$get_image = explode(',',$image);
					$count_image=count($get_image);
					$image_index=0;                              
					$item_id = base64_encode($item);								
			?>
			<aside class="col-md-6 border-right" >
				<div class="card mt-3 mb-3">
					<article class="gallery-wrap"> 
						<div class="img-big-wrap">
							<div id="product_image" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
							<?php for($image_index=0; $image_index < $count_image; $image_index++) { ?>
								<div class="carousel-item <?php if($image_index==0){echo "active";}?> p-3">
									<img src="images/items/<?php echo $get_image[$image_index]; ?>" class="d-block w-100 image-fluid " >
								</div>
							<?php } ?>							
							</div>
							<a class="carousel-control-prev text-secondary" href="#product_image" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#product_image" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
							</div>							
						</div> 					
					</article> <!-- gallery-wrap .end// -->
				</div> <!-- card.// -->
			</aside>
			<main class="col-md-6">
			<form method="POST" action="action.php">
				<article class="product-info-aside p-1">
					<h3 class="title mt-3 text-capitalize"><?php echo $items['product_name']; ?> </h3>
					<p><?php echo $items['product_description']; ?></p>
					<div class="col-12 p-0">
						<input type="tetx" class="form-control" name="item" value="<?php echo $product; ?>" hidden>
						<input type="tetx" class="form-control" name="item_in" value="<?php echo $product_in; ?>" hidden>
						<div class="border-bottom w-100 mb-1"><h5>Colors</h5></div>
						<div>
							<?php
							if(isset($_GET['size'])){
								$i = $_GET['size'];
							}
							else{
								$i=0; 
							}
							$color=$items['color'];
							$get_color=explode(',',$color);
							$count_color=count($get_color);
							$size=$items['product_size'];
							$get_size=explode(',',$size);
							$count_size=count($get_size);
							$color_index = 0;
							$size_index = 0;
							if(isset($_GET['color'])){
								$colors = $_GET['color'];
							}
							else{
								$colors =$get_color[$color_index]; 
							}
							?>
							<input  type="text" name="color" value="<?php echo $colors; ?>" required="" hidden>
							<input  type="text" name="size_id" value="<?php echo $i; ?>" required="" hidden>
							<ul class="size-select p-0">
							<?php							                                
							for($color_index=0; $color_index < $count_color; $color_index++) { ?>
								<li class="select-list">
									<a class="list text-capitalize <?php if($get_color[$color_index] == $colors){ echo 'border-primary'; } ?>" href="product_details.php?items=<?php echo $product; ?>&items_in=<?php echo $product_in; ?>&size=<?php echo $i; ?>&color=<?php echo $get_color[$color_index]; ?>"><?php echo $get_color[$color_index]; ?></a>		
								</li>															
							<?php } ?>
							</ul>
						</div>
						<div class="border-bottom w-100 mb-1"><h5>Sizes</h5></div>
						<div class="w-100">
							<ul class="size-select p-0">
							<?php							                                
							for($size_index=0; $size_index < $count_size; $size_index++) { ?>
								<li class="select-list">
									<a class="list <?php if($size_index == $i){ echo 'border-primary'; } ?>" href="product_details.php?items=<?php echo $product; ?>&items_in=<?php echo $product_in; ?>&size=<?php echo $size_index; ?>&color=<?php echo $colors; ?>"><?php echo $get_size[$size_index]; ?></a>		
								</li>															
							<?php } ?>
							</ul>
						</div>
						<div class="border-bottom w-100 mb-1"><h5>Price</h5></div>					
						<?php
						$price=$items['new_price'];
						$get_price=explode(',',$price);
						$stock=$items['in_stock'];
						$get_stock=explode(',',$stock);                                
						?>				
							<div class="price mb-3 w-100">
							<?php												
							$old=$items['old_price'];												
							$old_price=explode(',',$old);												
							echo "<i class='fa fa-rupee'></i> ".$get_price[$i];
							if ($old_price[$i] > $get_price[$i]) {
								$inc=$old_price[$i]-$get_price[$i];
								$increase=$inc/$old_price[$i]*100;
								$off = '<span class="product-discount-label text-danger">'.ceil($increase).'% off</span>';
								echo " <span><s><i class='fa fa-rupee'></i> " .$old_price[$i]."</s></span> " .$off;
							}
							?>
							</div>
							<div class="row">
								<div class="col-12 col-sm-4 mb-2" >
									<button type="submit" name="add_cart" class="btn  btn-cart  w-100 text-light"><i class="fa fa-shopping-cart"></i> <span class="text text-uppercase text-light">Add to Cart</span></button>											
								</div>
								<?php
								if($get_stock[$i] > 0){
								?>
								<div class="col-12 col-sm-4 mb-2" >											
									<button type="submit" name="purchase"   class="btn  btn-buy  w-100 text-light"><i class="fa fa-rupee "></i> <span class="text text-uppercase text-light">Buy Now</span></button>											
								</div>
								<div class="col-12 col-sm-4" >
									<a href="product.php" class="btn btn-primary button  w-100 text-light">
										<i class="fa  fa-chevron-left"></i> <span class="text text-uppercase text-light">Shop more</span>
									</a>
								</div>
								<?php }else{
									echo '<div class="col-12 col-sm-4" >
											<a href="product.php" class="btn btn-primary button  w-100 text-light">
												<i class="fa  fa-chevron-left"></i> <span class="text text-uppercase text-light">Shop more</span> 
											</a>
										</div>'; 												
									echo '<div class="col-12 col-sm-4" >
											<a  class="btn btn-danger button w-100 text-light">
												<i class="fa fa-exclamation-triangle"></i> <span class="text text-uppercase text-light">Out of stock</span>
											</a>
										</div>'; 
										} ?>											
							</div>
						</div>							
					<!-- col.// -->
					<?php } } ?>
				</article> <!-- product-info-aside .// -->
				</form>
				<?php
				if (isset($_SESSION['cart_message'])) {
					echo $_SESSION['cart_message'];
					unset($_SESSION['cart_message']);
				} ?>
			</main> <!-- col.// -->
		</div> <!-- row.// -->	
	</section>
	<?php 
	if (isset($_GET['items_in'])) {
		$product = $_GET['items_in'];
		$id = base64_decode($product);
	?>
	<section class="padding-bottom mt-2 mt-sm-2 mt-md-2 mt-lg-3 mt-xl-4">
		<header class="section-heading heading-line">
			<h4 class="title-section text-uppercase btn text-muted btn-primary">Similar Items</h4>
			<h4 class="title-section text-uppercase btn text-muted btn-primary float-right"><a href="product.php?similar_items=<?php echo $product; ?>">more</a></h4>
		</header>
		<div class="card card-home-category rounded-0">
			<div class="no-gutters">
				<div class="col-md-12 ">
					<ul class="row no-gutters mb-0 p-0">
						<?php similar_product($id); ?>
					</ul>
				</div> 
			</div> 
		</div> 
	</section>
		<?php  } ?>
</div> <!-- container .//  -->
<!-- Footer -->
<?php include 'footer.php'; ?>
<!-- Footer end -->
</body>
</html>
<?php
$db=$database->close();
}
?>