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
	
	<title>Sneekers | My Notification</title>
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
			</main>
  		</div>
 	</div>
</section>
<!-- footer -->
<?php include 'footer.php'; ?>
</body>
</html>
<?php
$db = $database -> close();
}
?>