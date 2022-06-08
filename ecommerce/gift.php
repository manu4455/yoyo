<!DOCTYPE HTML>
<html lang="en">
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
<head>
	<title>Sneekers | My Gift</title>
	<!-- Bootstrap cdn and custom css -->
	<?php include "link.php"; ?>
</head>
<body>
<!-- header section -->
<?php include "header.php"; ?>
<section class="section-content padding-y mt-4 bg-light">
	<div class="container-fluid bg-light">
		<div class="row">
			<main class="col-md-12">
				<div class="card border">
					<header class="card-header card-background text-light text-bold pl-1"><i class="fa fa-gift"></i> My Gift</header>
					<div class="row no-gutters  mb-1 border p-1">
					</div>
				<div>	    
             </main>
		</div>
	</div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
<?php
$db=$database->open();
}
?>