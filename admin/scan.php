<!doctype html>
<html>
<head>	
    <title>Admin | Package management</title>
	<?php include 'link.php'; ?>
</head>
<body class="bg-secondary">
    <div class="loader"></div>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include 'aside.php'; ?>
        <!-- Page Content  -->
        <div id="content">
            <?php include 'header.php'; ?>
            <div class="navigation col-12  bg-light justify-content-center justify-content-sm-left ">
                <div class="btn-group justify-content-center justify-content-sm-left">
                    <a href="dashboard.php" class="btn btn-default navigator rounded-0"><i class="fa fa-car"> Package & Dilivery</i></a>
                </div>
            </div>
            <section class="main mt-2">
				<div class="container-fluid  justify-content-center">
					<div class="row mt-10">
						<div class="col-12 col-md-3"></div>
						<div class="col-12 col-md-6 text-center  justify-content-center mt-10">
							<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>							
							<div class="col-sm-12 image-fluid">
								<video id="preview" class="p-1 border" style="width:100%; height:5%;"></video>
							</div>
							<script type="text/javascript">
								var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
								scanner.addListener('scan',function(content){
									window.location.href='http://localhost/ecommerce/admin/package.php?order_id='+content;
								});
								Instascan.Camera.getCameras().then(function (cameras){
									if(cameras.length>0){
										scanner.start(cameras[0]);
										$('[name="options"]').on('change',function(){
											if($(this).val()==1){
												if(cameras[0]!=""){
													scanner.start(cameras[0]);
												}else{
													alert('No Front camera found!');
												}
											}else if($(this).val()==2){
												if(cameras[1]!=""){
													scanner.start(cameras[1]);
												}else{
													alert('No Back camera found!');
												}
											}
										});
									}else{
										console.error('No cameras found.');
										alert('No cameras found.');
									}
								}).catch(function(e){
									console.error(e);
									alert(e);
								});
							</script>
							<div class="row">
								<div class="col-6">
									<label class="btn btn-primary active w-100 text-nowrap">
										<input type="radio" name="options" value="1" autocomplete="off"> Front Camera
									</label>
								</div>								
								<div class="col-6">
									<label class="btn btn-secondary w-100 text-nowrap">
										<input type="radio" name="options" value="2" autocomplete="off"> Back Camera
									</label>
								</div>								
							</div>
						</div>
						<div class="col-12 col-md-3"></div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
