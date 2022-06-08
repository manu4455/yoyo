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
		<title>Sneekers | Product Listing</title>
		<!-- Bootstrap cdn and custom css -->
		<?php include "link.php"; ?>
	</head>
	<body>
	<div class="loader"></div>
		<!-- Header -->
		<?php include "header.php"; ?>
		<!-- Header End -->
		<?php include "function.php"; ?>
		<!-- Sesction Product -->
		<section class="section-content padding-y w-100 mt-1">
			<div class="container-fluid">
				<div class="row">
					<div class="col-6 bg-light  text-center pr-0 text-primary">
						<button type="submit" class="w-100 btn btn-light rounded-0"><i class="fa fa-sort"></i> SORT BY</button>
					</div>
					<div class="col-6 bg-light text-center pl-0 text-primary">
						<button type="submit" class="w-100 btn btn-light rounded-0" id="filter-button"><i class="fa fa-filter"></i> FILTER</button>
					</div>
				</div>
			</div>
		</section>
		<section class="section-content padding-y mt-1">
			<div class="container-fluid">
				<div class="card card-home-category rounded-0">
					<div class="no-gutters">
						<div class="col-md-12 ">
							<ul class="row no-gutters">
							<?php
							if (isset($_GET['category'])) {
								$category = $_GET['category'];
								$id = base64_decode($category);
								get_product($id);
							}
							if (isset($_GET['shopby'])) {
								$category = $_GET['shopby'];
								$id = base64_decode($category);
								shopby($id);
							}
							if (isset($_GET['similar_items'])) {
								$category = $_GET['similar_items'];
								$id = base64_decode($category);
								similar_product($id);
							}
							
							if ((!isset($_GET['shopby'])) && (!isset($_GET['category'])) && (!isset($_GET['similar_items'])) ) {
								all_product();
							}
							?>
							</ul>
						</div> 
					</div>
					<div class="filter col-12 col-sm-12 col-md-4 absolute pr-0 pl-0" id="filter">
						<div class="card">
							<article class="filter-group">
								<header class="card-header">									
									<h6 class="title">Category <span aria-hidden="true" id="filter-close" class="float-right btn btn-light text-secondary border-0"><a ><i class="fa fa-times"></i></a></span></h6>									
								</header>
								<div class="filter-content collapse show" id="category" style="">
									<div class="card-body">
										<ul class="nav nav-tabs tabss mb-1 text-capitalize" id="categoryTab" role="tablist">
										<?php
										function sublink($ids){
											global $db;
											$get_category=$db->query("SELECT * FROM category WHERE parent_id=$ids");
											if($get_category->num_rows > 0){
												while($sublink=$get_category->fetch_assoc()){
													?>
													<label class="custom-control custom-checkbox">
													<input type="checkbox" value="<?php echo $sublink['category_name']; ?>" class="custom-control-input">
													<div class="custom-control-label text-capitalize"><?php echo $sublink['category_name']; ?></div>
													</label>			 
													<?php
													sublink($sublink['cat_id']);
												}
											}
										}
										$id=0;
										$get_category=$db->query("SELECT * FROM category WHERE parent_id=$id");
										if($get_category->num_rows > 0){
											while($row=$get_category->fetch_assoc()){ 
										?>
											<li class="nav-item a px-1 text-capitalize">
												<a class="nav-link" id="<?php echo $row['category_name']; ?>-tab" data-toggle="tab" href="#<?php echo $row['category_name']; ?>" role="tab" aria-controls="<?php echo $row['category_name']; ?>" aria-selected="true"><?php echo $row['category_name']; ?></a>
											</li>
										<?php
											}
										?>
										</ul>
										<div class="tab-content" id="categoryTabContent">
											<?php
											$get_sub=$db->query("SELECT * FROM category WHERE parent_id=$id");
											while($sub=$get_sub->fetch_assoc()){
											?>
											<div class="tab-pane fade sub-cat" id="<?php echo $sub['category_name']; ?>" role="tabpanel">
												<?php sublink($sub['cat_id']); ?>
											</div>
											<?php
											}
											?>									
										</div>
										<?php
										}
										?>										
									</div> <!-- card-body.// -->
								</div>
							</article> <!-- filter-group  .// -->
							<article class="filter-group">
								<header class="card-header border-top">
									<h6 class="title">Brands</h6>								
								</header>
								<div class="filter-content collapse show" id="brand" style="">
									<div class="card-body">
									<?php
										$brand=$db->query("SELECT * FROM brand");
										if($brand->num_rows > 0){
											while($brands=$brand->fetch_assoc()){ 
										?>
										<label class="custom-control custom-checkbox">
										<input type="checkbox" value="<?php echo $brands['brand_id']; ?>" class="custom-control-input">
										<div class="custom-control-label text-capitalize"><?php echo $brands['brand_name']; ?>
											</div>
										</label>
										<?php
											}
										}
										?>										
									</div> <!-- card-body.// -->
								</div>
							</article> <!-- filter-group .// -->
							<article class="filter-group">
								<header class="card-header border-top rounded-0">								
									<h6 class="title">Price range </h6>									
								</header>
								<div class="filter-content" id="price" style="">
									<div class="card-body">
										<div class="form-row">
										<div class="form-group col-md-6">
										<label>Min</label>
										<input class="form-control" placeholder="0" type="number">
										</div>
										<div class="form-group text-right col-md-6">
										<label>Max</label>
										<input class="form-control" placeholder="0" type="number">
										</div>
										</div> <!-- form-row.// -->										
									</div><!-- card-body.// -->
									<div class="card-footer">
										<button type="submit" name="filter" id="filter-apply" class="btn btn-secondary w-100 rounded-0">Apply</button>
									</div>
								</div>
							</article> <!-- filter-group .// -->
						</div>
					</div> 
				</div>						
			</div> 
		</section>
		<!-- Sesction Product End -->
		<!-- Footer  -->
		<?php include 'footer.php'; ?>
		<!-- Footer End-->
	</body>
</html>
<?php $db=$database->close(); }?>