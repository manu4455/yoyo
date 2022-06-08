<?php
session_start();
include "dbconfig/dbconfig.php";
$db=$database->open();
include "function.php";
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
		<!-- Banner & Category menu accordian -->
	<div class="container-fluid">
		
		<section class="section-main mt-2">
			<main class="card rounded-0 h-80">
			<!-- Category Banner -->
				<div id="category" class="slider-home-banner carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php indicator(); ?>
				</ol>
				<div class="carousel-inner">
					<?php crausal_items(); ?>
				</div>
				<a class="carousel-control-prev" href="#category" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#category" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
				</div> 
			<!-- Category Banner End -->	 
			</main> 
		</section>
		<!-- Category Items -->
		<?php
		$id=0; 
		$main_category=$db->query("SELECT * FROM category WHERE parent_id=$id");
		if($main_category->num_rows > 0){
			while($row=$main_category->fetch_assoc()){
		?>
		<section class="padding-bottom mt-2">
			<header class="section-heading heading-line">
				<h4 class="title-section text-uppercase btn text-muted btn-primary"><?php echo $row['category_name']; ?></h4>
				<h4 class="title-section text-uppercase btn text-muted btn-primary float-right"><a href="product.php?category=<?php $cat_id=$row['cat_id']; echo base64_encode($cat_id); ?>">more</a></h4>
			</header>
			<div class="card card-home-category rounded-0">
				<div class="no-gutters ">
					<div class="col-md-12 ">
						<ul class="row no-gutters mb-0 p-0">
							<?php get_product($row['cat_id']); ?>
						</ul>
					</div> 
				</div> 
			</div> 
		</section>
		<?php
			}
		}
		recomended();
		?>
	</div>

<?php
if (isset($_SESSION['message'])) {
	echo $_SESSION['message'];
	unset($_SESSION['message']);
}
$message="";
if (isset($_POST['register'])) {    
    $name=$_POST['name'];
    $email=$_POST['email'];
    $country=$_POST['country'];
    $gender=$_POST['gender'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $pin=$_POST['pin'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $pass=$_POST['pass'];
    $password=sha1($pass);
	$image="user_default_image.png";
	$check_user = $db -> query("SELECT * FROM customers WHERE email='$email'");
	if($check_user -> num_rows >=1){
		echo $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<strong><i class="fa fa-warning"></i> Warning </strong> <p> User already exits</p>
					</div>';		 
	}else{
		$register_user = $db -> query("INSERT INTO customers(names,email,gender,country,states,city,pin,phone,addres,passwords,image)VALUES('$name','$email','$gender',$country,$state,$city,$pin,$phone,'$address','$password','$image')");
		if ($register_user) {
			echo $message='<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<strong ><i class="fa fa-check"></i> Success </strong> <p> Registered Successfully</p>
			</div>';
		}
		else{
			echo $message='<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<strong><i class="fa fa-warning"></i> Error </strong> <p> Oops ! something went wrong!</p>
			</div>';
		}
	}
}
?>
	<!-- Footer-->
	<?php include 'footer.php'; ?>
	<!-- Footer end-->
	</body>
</html>
<?php $db=$database->close(); ?>