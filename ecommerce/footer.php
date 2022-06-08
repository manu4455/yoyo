	<footer class="section-footer bg-secondary mt-2 mt-sm-2 mt-md-2 mt-lg-3 mt-xl-4">
		<div class="container ">
			<section class="footer-top padding-y-lg text-white justify-content-center">
				<div class="row ">
					<aside class="col-md col-6">
						<h6 class="title">Top category</h6>
						<ul class="list-unstyled text-capitalize">
						<?php
						$id=0;
						$limit = 5;
						$get_category=$db->query("SELECT * FROM category WHERE parent_id=$id limit $limit");
						if($get_category->num_rows > 0){
							while($row=$get_category->fetch_assoc()){ 
						?>
							<li> <a  href="product.php?category=<?php $cat_id=$row['cat_id']; echo base64_encode($cat_id); ?>"><?php echo $row['category_name']; ?></a></li>
							<?php	
							}
						}
						?>					
						</ul>
					</aside>
					<aside class="col-md col-6">
						<h6 class="title">Company</h6>
						<ul class="list-unstyled">
							<li> <a href="about.php">About us</a></li>
						</ul>
					</aside>
					<aside class="col-md col-6">
						<h6 class="title">Help</h6>
						<ul class="list-unstyled">
							<li> <a href="contact.php">Contact us</a></li>
							<li> <a href="orders.php">My order</a></li>
							<li> <a href="tracking.php">Order status</a></li>
							
						</ul>
					</aside>
					<aside class="col-md col-6">
						<h6 class="title">Account</h6>
						<ul class="list-unstyled">
							<li> <a href="account.php"> Profile Setting </a></li>
						</ul>
					</aside>
				</div> <!-- row.// -->
			</section>	<!-- footer-top.// -->

			<section class="footer-bottom text-center">
			
					<p class="text-white">Privacy Policy - Terms of Use - User Information Legal Enquiry Guide</p>
					<p class="text-muted"> &copy <?php echo date("Y"); ?> Sneakers, All rights reserved </p>
					<br>
			</section>
		</div><!-- //container -->
	</footer>
	</div>
</div>
<div class="overlay"></div>
<script type="text/javascript">
	$(document).ready(function () {

		$('#sidebar, .overlay').on('click', function () {
			$('#sidebar').removeClass('active');
			$('.overlay').removeClass('active');
		});

		$('#sidenav-button').on('click', function () {
			$('#sidebar').addClass('active');
			$('.overlay').addClass('active');
			$('.collapse.in').toggleClass('in');
			$('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});
	});
</script>
<!-- Modal account -->
<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-key"></i> Account</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-footer">
		<form method="POST" action="action.php">
			<button type="submit" class="btn btn-secondary" name="logout"> <i class="fa fa-sign-out"></i> Logout</button>
			<a href="account.php" class="btn btn-primary"> <i class="fa fa-user"></i> Account</a>
		</form>
	  </div>
	</div>
  </div>
</div>
</div>
<!-- Modal register  -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Register</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form method="POST" action="">  
		<div class="modal-body">
			<div class="form-row">
				<div class="col-md-6 form-group">
					<label>Full Name *</label>
					<input type="text" name="name" class="form-control" placeholder="Customer full name" required="" pattern="[A-Za-z ]*" title="Please enter your name in alphabetic ">
				</div> <!-- form-group end.// -->
				<div class="col-md-6 form-group">
					<label>Phone No *</label>
					<input type="number" name="phone" class="form-control" placeholder="Customer phone number" required=""  pattern="[0-9]" title="Pleasle enter 10 digit phone number">
				</div> 
				<div class="col-md-12 form-group">
					<label>Email *</label>
					<input type="email" name="email" class="form-control" placeholder="Customer email id" required="" title="Pleasle enter valid email ID">
				</div> <!-- form-group end.// -->
				<div class="col-md-12 form-group">
					<label>Pincode *</label>
					<input type="number" name="pin" class="form-control" placeholder="Customer pincode" required="" pattern="[0-9]*" title="Pleasle enter 6 digit pincode" >
				</div> <!-- form-group end.// -->
				</div> <!-- form-row end.// -->
				<div class="form-group">
					<label>Address *</label>
					<textarea class="form-control" name="address" required=""></textarea>
				</div> <!-- form-group end.// -->
				<div class="form-group">
					<label class="custom-control custom-radio custom-control-inline">
					  <input class="custom-control-input" type="radio" name="gender" value="M" required="">
					  <span class="custom-control-label"> Male </span>
					</label>
					<label class="custom-control custom-radio custom-control-inline">
					  <input class="custom-control-input" type="radio" name="gender" value="F" required="">
					  <span class="custom-control-label"> Female </span>
					</label>
					<label class="custom-control custom-radio custom-control-inline">
					  <input class="custom-control-input" type="radio" name="gender" value="O" required="">
					  <span class="custom-control-label"> Others </span>
					</label>
				</div> <!-- form-group end.// -->
				<div class="form-row">
					<div class="form-group col-md-4">
					  <label>Country *</label>
					  <select id="countrys" class="form-control" name="country">
					    <?php
						 $country= $db -> query("SELECT * FROM country WHERE status=1");
						 if($country -> num_rows > 0){
							echo '<option value="">Select country</option>';
							while ($row = $country -> fetch_assoc()) {
								echo '<option value='.$row['id'].'>'.$row['country_name'].'</option>';
							}
						 }
						?>
					  </select>
					</div> <!-- form-group end.// -->
					<div class="form-group col-md-4">
					  <label>State *</label>
					  <select id="states" class="form-control" name="state" required="">
					  </select>
					</div> <!-- form-group end.// -->
					<div class="form-group col-md-4">
					  <label>City *</label>
					  <select id="city" class="form-control" name="city" required="">					    
					  </select>
					</div> <!-- form-group end.// -->
				</div> <!-- form-row.// -->
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Create password *</label>
					    <input class="form-control" type="password" name="pass" placeholder="Password" required="">
					</div> <!-- form-group end.// -->  
				</div>
			    <div class="form-group">			        
			    	<button type="button" class="btn btn-danger w-100" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
					<button type="submit" class="btn btn-secondary w-100 mt-2" name="register" data-toggle="modal" data-target="#process"><i class="fa fa-registered"></i> Register</button>
				</div> <!-- form-group// -->      
			    <div class="form-group"> 
		            <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""> <div class="custom-control-label"> I am agree with <a href="policy.php">terms and contitions</a>  </div> </label>
		            <p class="text-center mt-4">Have an account? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i> Log In</a></p>
		        </div> 
		</div>
	</form>
	</div>
  </div>
</div>
<!-- Modal login -->
<div class="modal fade <?php if(isset($_SESSION['login'])){ echo "show";} ?>" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" <?php if(isset($_SESSION['login'])){ echo 'aria-modal="true"'; echo 'style="display:block;"'; unset($_SESSION['login']);}else{ echo 'aria-hidden="true"';} ?>>
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Login</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form method="POST" action="action.php">
	  <div class="modal-body">
	    <div class="form-row">
			<div class="form-group col-12">
				<label>Email Id *</label>
				<input class="form-control" type="email" name="email" placeholder="Enter your registered email" required="">
			</div> <!-- form-group end.// --> 
			<div class="form-group col-12">
				<label>Password *</label>
				<input class="form-control" type="password" name="password" placeholder="Enter your password" required="">
			</div> <!-- form-group end.// -->
			</div>
			<div class="form-group">			        
			    	<button type="button" class="btn btn-secondary w-100" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
					<button type="submit" name="login" class="btn btn-primary w-100 mt-2"><i class="fa fa-sign-in"></i> login</button>
				</div> <!-- form-group// -->      
			    <div class="form-group"> 
		            <p class="text-center mt-4">Dont have an account? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#register"><i class="fa fa-Register"></i> Register</a></p>
		        </div>
		</div>		
	  </form>
	</div>
  </div>
</div>