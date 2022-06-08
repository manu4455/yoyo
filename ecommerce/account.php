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
$id = $_SESSION['id'];
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Sneekers | My Account</title>
	<?php include "link.php"; ?>
</head>
<body>
<div class="loader"></div>
<!-- header section -->
<?php include "header.php"; ?>
<section class="section-content padding-y mt-4 bg-light">
	<div class="container-fluid bg-light">
		<div class="row">
			<main class="col-md-12">
				<article class="card mb-3">
					<header class="card-header">My Profile</header>
					<div class="card-body">
					<?php
					$profile = $db -> query("SELECT * FROM customers INNER JOIN country ON customers.country=country.id INNER JOIN states ON customers.states=states.id INNER JOIN city ON customers.city=city.id WHERE customers.id=$id");
					if($profile ->num_rows>=1){
						$row = $profile -> fetch_assoc();
					?>				
						<figure class="icontext">
								<div class="icon">
									<img class="rounded-circle img-sm border" src="images/avatars/<?php echo $row['image']; ?>" alt="image">
								</div>
								<div class="text">
									<strong class="text-capitalize"> <?php echo $row['names']; ?> </strong> <br> 
									<?php echo $row['email']; ?> <br> 
									<a href="#">Edit</a>
								</div>
						</figure>
					
						<hr>
						<p class="text-capitalize p-1">
							<i class="fa fa-map-marker text-muted"></i> &nbsp; My address:  
							<br>
							<?php echo $row['addres']." ".$row['pin']."<br>".$row['city_name']." , ".$row['state_name']." , ".$row['country_name'];  ?> &nbsp; 
							<a href="#" class="btn-link"> Edit</a>
						</p>
						<?php } ?>
						<article class="card-group row">
							<figure class="card bg col-6 col-md-3">
								<div class="p-3">
									<h5 class="card-title btn btn-primary">
										<?php 
										$order = $db -> query("SELECT count(id) FROM orders WHERE customer_id = $id");
										$count = $order -> fetch_row();  
                                        echo $count[0];
										?>
									</h5>
									<span>Orders</span>
								</div>
							</figure>
							<figure class="card bg col-6 col-md-3">
								<div class="p-3">
									<h5 class="card-title btn btn-primary">5</h5>
									<span>Wishlists</span>
								</div>
							</figure>
							<figure class="card bg col-6 col-md-3">
								<div class="p-3">
									<h5 class="card-title btn btn-primary">12</h5>
									<span>Awaiting delivery</span>
								</div>
							</figure>
							<figure class="card bg col-6 col-md-3">
								<div class="p-3">
									<h5 class="card-title btn btn-primary">50</h5>
									<span>Delivered items</span>
								</div>
							</figure>
						</article>
					</div> <!-- card-body .// -->
					</article> <!-- card.// -->
					<article class="card  mb-3">
						<div class="card-body">
							<h5 class="card-title mb-4">Recent orders </h5>
							<div class="row">
								 <!-- col.// -->
								 <!-- col.// -->
								<!-- col.// -->
							</div> <!-- row.// -->

							<a href="orders.php" class="btn btn-outline-primary"> See all orders  </a>
						</div> <!-- card-body .// -->
					</article> <!-- card.// -->
				</main> <!-- col.// -->
			</div>
		</div> <!-- container .//  -->
	</div>
</section>
<!-- Footer -->

</body>
</html>
<?php $db=$database->close(); }?>