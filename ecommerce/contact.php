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
		
		
		<section align-text:center;>
				<h1>Contact Us Page</h1>
				<p>12345678</p>
				<p>0987654</p>
		</section>
		<!-- Category Items -->
		<?php
		$id=0; 
		$main_category=$db->query("SELECT * FROM category WHERE parent_id=$id");
		if($main_category->num_rows > 0){
			while($row=$main_category->fetch_assoc()){
		?>
		
		<?php
			}
		}
		recomended();
		?>
	</div>


	<!-- Footer-->
	<?php include 'footer.php'; ?>
	<!-- Footer end-->
	</body>
</html>
<?php $db=$database->close(); ?>