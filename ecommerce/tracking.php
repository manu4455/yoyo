<?php
session_start();
date_default_timezone_set('Asia/kolkata');
if(!isset($_SESSION['id'])|| ($_SESSION['id']=='') && ($_SESSION['email'])|| ($_SESSION['email']=='') && ($_SESSION['name'])|| ($_SESSION['name']=='') )
{ 
	$_SESSION['login']="login";
	header("location:index.php");
}
else{
include "dbconfig/dbconfig.php";
$db=$database->open();
$id = $_SESSION['id'];
?>
<!DOCTYPE HTML>
<html lang="en">
<head>	
	<title>Sneakers | Order Tracking</title>
	<!-- Bootstrap cdn and custom css -->
	<?php include "link.php"; ?>
</head>
<body>
<!-- header section -->
<?php include "header.php"; ?>
<!-- tracking -->
<section class="section-content padding-y mt-4 bg-light">
	<div class="container-fluid bg-light">
		<div class="row">	
			<main class="col-md-12">
				<article class="card">
					<header class="card-header"> My Orders / Order status </header>
					<div class="card-body">
					<?php 
					if(isset($_GET['track_order'])){
						$track = $_GET['track_order'];
						$myorder = $db ->query("SELECT  DISTINCT order_progress.order_id,order_progress.date,order_progress.status_id,order_status.status_name FROM order_progress INNER JOIN order_status ON order_progress.status_id=order_status.status_id WHERE order_progress.order_id = '$track' ORDER BY order_progress.order_id DESC ");
						if($myorder -> num_rows >=1){
						?>
						<div class="card mb-3 border">
							<div class="p-2 text-left text-white text-lg bg-secondary rounded-top"><span > <?php echo '<h6>Order ID: '.$_GET['track_order'].' </h6>'; ?></span></div>
							<div class="card-body p-2">
								<div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
							<?php
							while ($order = $myorder -> fetch_assoc()){
							$date = $order['date'];
							?>
									<div class="step completed">
										<div class="step-icon-wrap">
										<?php if($order['status_id']==1){?>
										<div class="step-icon"><i class="pe-7s-cart"></i></div>
										<?php }?>
										<?php if($order['status_id']==2){?>
											<div class="step-icon"><i class="pe-7s-check"></i></div>
										<?php }?>
										<?php if($order['status_id']==3){?>
											<div class="step-icon"><i class="pe-7s-gift"></i></div>
										<?php }?>
										<?php if($order['status_id']==4){?>
											<div class="step-icon"><i class="pe-7s-car"></i></div>
										<?php }?>
										<?php if($order['status_id']==5){?>
											<div class="step-icon"><i class="pe-7s-home"></i></div>
										<?php }?>
										<?php if($order['status_id']==6){?>
											<div class="step-icon"><i class="pe-7s-close-circle"></i></div>
										<?php }?>
										</div>
										<h4 class="step-title"><?php  echo $order['status_name']; ?> </h4><span class="step-title"> <?php echo date("M-dS-Y H:i:s a", $date);  ?></span>
									</div>
							<?php } ?>
								</div>
							</div>
							</div>
								<?php
							}
						}			
					?>
					<a href="orders.php" class="btn btn-light mb-2"> <i class="fa fa-chevron-left"></i> Back to orders</a>
					</div> <!-- card-body -->
				</article>
			</main>
		</div>
	</div>
</section>
<!-- tracking end-->
<!-- footer -->
<?php include 'footer.php'; ?>
</body>
</html>
<?php $db=$database->close(); }?>