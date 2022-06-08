<div id="sidebar" class=" d-lg-none">
<div class="col-12  p-0" id="sidenav">
	<div class="media border-bottom p-3 bg-secondary sidenav-header">
	  <img src="images/avatars/<?php if(isset($_SESSION['image'])){ echo $_SESSION['image']; }else{echo "user_default_image.png";} ?>" alt="image" class="rounded-circle img-fluid" style="width:60px;"> <span id="side-bar-name " class="text-light" style="margin-top:20px; padding-left:20px;"><?php if(isset($_SESSION['name'])){ $name = $_SESSION['name'];  echo ucfirst($name);}else{ echo "Hello Users";} ?></span><i class="fa fa-arrow-left text-light" id="close-sidenav"></i> 
	</div>
	<ul class="nav flex-column border-bottom bg-secondary">
		<li class="nav-item">
		  <a class="nav-link" href="gift.php"><i class="pe-7s-gift"></i> Gift zone</a>
		</li>
	</ul>
	<ul class="nav flex-column border-bottom bg-secondary">
		<li class="nav-item">
		   <a class="nav-link" href="orders.php"><i class="pe-7s-box2"></i> My order</a>
		</li>
		<li class="nav-item">
		   <a class="nav-link " href="cart.php"><i class="pe-7s-cart"></i> My cart</a>
		</li>
		<li class="nav-item">
		   <a class="nav-link" href="wishlist.php"><i class="pe-7s-like"></i> My wishlist</a>
		</li>
		<li class="nav-item">
		   <a class="nav-link" href="account.php"><i class="pe-7s-door-lock"></i> My account</a>
		</li>
		<li class="nav-item">
		   <a class="nav-link " href="notify.php"><i class="pe-7s-bell"></i> My notification</a>
		</li>
	</ul>
	<ul class="nav flex-column border-bottom bg-secondary">
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
		}else{
			?>
		<li class="nav-item">
			<a class="nav-link" href="" data-toggle="modal" data-target="#account"><i class="pe-7s-user"></i> <?php if(isset($_SESSION['name'])){ $name = $_SESSION['name'];  echo ucfirst($name);} ?></a>
		</li>
			<?php
		}
		?>
	</ul>		
</div>
</div>