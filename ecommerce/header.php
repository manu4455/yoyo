<div class="wrapper">
<!-- Sidebar  -->
	<?php include 'sidebar.php'; ?>
	<!-- Page Content  -->
	<div id="content">
		<div id="wish"></div>
		<header class="section-header bg-secondary text-light">
			<section class="header-main border-bottom">
				<div class="container-fluid">
					<div class="row align-items-center p-2">
						<div class="col-6 logo-pading text-left">
							<a href="index.php" class="logo-wrap logo">
								<img class="logo-image" src="images/logo/logo.png" class="image-fluid" width="200" height="45">					
							</a> <!-- logo-wrap -->
						</div>
						<div class="col-6 logo-pading">
							<div class=" float-right d-flex">
								<div class="widget-header">
									<a href="notify.php" class="widget-view">
										<div class="icon-area">
											<i class="pe-7s-bell"></i>
											<?php if (isset($_SESSION['id'])) { echo '<span class="notify"></span>'; }?>
										</div>
									</a>
								</div>
								<div class="widget-header">
									<a href="cart.php" class="widget-view">
										<div class="icon-area">
											<i class="pe-7s-cart"></i>
											<?php if (isset($_SESSION['id'])) { echo '<span class="notify"></span>'; }?>								
										</div>
									</a>
								</div>
								
							</div> <!-- widgets-wrap.// -->
						</div> <!-- col.// -->
					</div> <!-- row.// -->
				</div> <!-- container.// -->
			</section> <!-- header-main .// -->
			<nav class="navbar navbar-main navbar-expand-lg border-bottom pb-1 pt-1 logo-pading">
			<div class="container-fluid p-0">
				<button class="navbar-toggler text-light rounded-0 " type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation" id="sidenav-button">
				<i class="fa fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse d-none d-sm-none d-md-none d-lg-blok" id="main_nav">
				<ul class="navbar-nav">
					<li class="nav-item">
					<a class="nav-link" href="orders.php"><i class="fa fa-first-order"></i> My orders </a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="wishlist.php"><i class="fa fa-heart-o"></i> My wishlist </a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="notify.php"><i class="fa fa-bell-o"></i> My notification </a>
					</li>
					<!-- <li class="nav-item">
					<a class="nav-link" href="lucky_draw.php" title="Try your luck once"><i class="fa fa-gift"></i> Gift zone </a>
					</li> -->
				</ul>
				<ul class="navbar-nav ml-md-auto">
					<?php
					if(!isset($_SESSION['id'])|| ($_SESSION['id']==''))
					{					
					?>      	  
					<li class="nav-item">
						<a class="nav-link" href="" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i> Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="" data-toggle="modal" data-target="#register"><i class="fa fa-registered"></i> Register</a>
					</li>
					<?php
					}
					else{
					$u_id = $_SESSION['id'];
					$profile = $db->query("SELECT * FROM customers WHERE id = $u_id");
					$user_date = $profile ->fetch_assoc();
						?>
						<li class="nav-item">
						<a class="nav-link" href="" data-toggle="modal" data-target="#account"><img src="images/avatars/<?php echo $user_date['image']; ?>" alt="image" class="rounded-circle img-fluid" style="width:30px;"> <?php if(isset($_SESSION['name'])){ $name = $_SESSION['name'];  echo ucfirst($name);} ?></a>
						</li>
						<li class="nav-item ">
							<a class="nav-link" onclick="goBack()" ><i class="fa fa-angle-left btn btn-primary"> Back </i></a>
						</li>
						<?php
					}
					?>
				</ul>
				</div> 
			</div>
			</nav>
		</header> <!-- section-header.// -->
