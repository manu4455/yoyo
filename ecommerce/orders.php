<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['id'] == '') && ($_SESSION['email']) || ($_SESSION['email'] == '') && ($_SESSION['name']) || ($_SESSION['name'] == '')) {
	$_SESSION['login'] = "login";
	header("location:index.php");
} else {
include "dbconfig/dbconfig.php";
$id = $_SESSION['id'];
$db=$database->open();
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Sneakers | My Orders</title>
    <!-- Bootstrap cdn and custom css -->
    <?php include "link.php"; ?>
</head>
<body>
<div class="loader"></div>
    <!-- header section -->
    <?php include "header.php"; ?>
    <section class="section-content padding-y mt-1 bg-light">
        <div class="container-fluid bg-light ">
            <div class="row">
                <main class="col-md-12">
                    <div class="card border">
					    <header class="card-header card-background text-light text-bold pl-1"><i class="fa fa-first-order"></i> My Orders</header>
					    <div id="cart_item" class="mt-1 pl-1 pr-1">
						<?php 
						$myorder = $db ->query("SELECT * FROM orders INNER JOIN products ON orders.product_id=products.product_id WHERE orders.customer_id = $id ORDER BY id DESC");
						if($myorder -> num_rows >=1){
						while ($order = $myorder -> fetch_assoc()){
							$i=0;
							$itm = $order['product_id'];
							$item = base64_encode($itm);
							$item_in = $order['categorys'];
							$image=$order['images'];
                			$get_image=explode(',',$image);
						?>
                        <div class="row no-gutters  mb-1 border p-1">
                            <aside class="col-4 col-sm-4 col-md-3  col-lg-3  text-center text-sm-left info-left pl-2 pr-2 pt-2 pb-3">
                                <div class="img-lg img-sm">
                                    <img src="images/items/<?php echo $get_image[$i]; ?>" class="img-fluid" >
                                <div>
                            </aside> <!-- col.// -->
                            <div class="col-8 col-sm-8 col-md-4 col-lg-3 p-2 ">
                                <div class="info-main">
                                    <a  class="h5 title text-capitalize font-weight-bold text-dark"><?php echo $order['product_name']; ?> </a>
                                </div> <!-- info-main.// -->
                                <figcaption class="info col-12 text-capitalize d-flex pl-0">
                                    <p class="text-muted small">Size: <?php echo $order['size'];  ?>, Color: <?php echo $order['order_color']; ?></p>
                                </figcaption>
                            </div> <!-- col.// -->
                            <aside class="col-12 col-sm-12  col-md-5 col-lg-4 p-2">
                                <div class="info-aside">
                                    <div class="price-wrap">
                                        <span class="h5 price"><i class="fa fa-rupee"></i> <?php echo $order['amount'] . "/-"; ?></span>
                                    </div> <!-- price-wrap.// -->
                                    <!-- <small class="text-success">Free shipping</small> -->
                                    <p class="text-muted mt-1">Sneakers Pvt Ltd</p>
                                    <div>                                    
                                        <a href="tracking.php?track_order=<?php echo $order['order_id']; ?>" class="btn btn-primary">Track order</a> 
                                        <a href="product_details.php?items=<?php echo $item; ?>&items_in=<?php echo base64_encode($item_in); ?>" class="btn btn-light"> Details </a>
                                        <a href="product_details.php?items=<?php echo $item; ?>&items_in=<?php echo base64_encode($item_in); ?>" class="btn btn-danger"> Cancel </a>  
                                    </div>
                                </div> <!-- info-aside.// -->
                            </aside>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 p-2 border-top">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-2 text-center"><i class="fa fa-star-o text-success"></i></div>
                                    <div class="col-2 text-center"><i class="fa fa-star-o text-success"></i></div>
                                    <div class="col-2 text-center"><i class="fa fa-star-o text-success"></i></div>
                                    <div class="col-2 text-center"><i class="fa fa-star-o text-success"></i></div>
                                    <div class="col-2 text-center"><i class="fa fa-star"></i></div>
                                </div>
                            </div>
						</div> <!-- row.// -->
						<?php } }?>	
                        </div>
					</div>
                </main> <!-- col.// -->
            </div>
        </div> <!-- container .//  -->
    </section>
    <!-- Footer-->
	<?php include 'footer.php'; ?>
	<!-- Footer end-->
</body>
</html>
<?php $db=$database->close(); } ?>