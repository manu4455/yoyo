<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['id'] == '') && ($_SESSION['email']) || ($_SESSION['email'] == '') && ($_SESSION['name']) || ($_SESSION['name'] == '')) {
	$_SESSION['login'] = "login";
	header("location:index.php");
} else {
	include "dbconfig/dbconfig.php";
	$db = $database->open();
	$id = $_SESSION['id'];	
	$info = $db ->query("SELECT * FROM customers WHERE id = $id");
	$row = $info -> fetch_assoc();
	$address = $row['addres'];	
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
	<title>Sneekers | Order Process</title>
	<?php include "link.php"; ?>
</head>

<body>
<div class="loader"></div>
	<!-- header section -->
	<?php include "header.php"; ?>
	<section class="section-content padding-y mt-4 bg-light">
		<div class="container-fluid">
			<main class="col-md-12">					
				<!-- -->
				<div class="container-fluid" id="grad1">
					<div class="row justify-content-center mt-0">
						<div class="col-12 text-center p-0 mt-0 mb-2">
							<div class="card rounded-0 px-0 pt-4 pb-0 mb-3">
								<h2><strong>Order Processing</strong></h2>
								<div class="row">
									<div class="col-md-12 mx-0">
										<form id="msform" method="POST" action="payment.php">
											<!-- progressbar -->
											<ul id="progressbar">
												<li class="<?php if(isset($_SESSION['payment_status'])){ echo 'active'; }else{ echo "active"; }?>" id="account"><strong>Personal Info</strong></li>
												<li id="personal" class="<?php if(isset($_SESSION['payment_status'])){ echo "active"; }?>"><strong>Shipping Address</strong></li>
												<li id="payment" class="<?php if(isset($_SESSION['payment_status'])){ echo "active"; }?>"><strong>Payment</strong></li>
												<li id="confirm" class="<?php if(isset($_SESSION['payment_status'])){ echo "active";}?>"><strong>confirm</strong></li>
											</ul> <!-- fieldsets -->
											<fieldset <?php if(isset($_SESSION['payment_status'])){ echo 'style="display: none; position: relative; opacity: 0;"';}?>>
												<div class="form-card ">
													<h2 class="fs-title">Confirm Account</h2> 
													<input type="email" name="email" placeholder="Email Id" value="<?php echo $_SESSION['email']; ?>" readonly /> 
													<input type="text" name="uname" placeholder="UserName"  value="<?php echo $_SESSION['name']; ?>" readonly />
													 
												</div>
												<button type="button" name="next" class="next action-button btn btn-secondary float-right mr-4" > Proceed </button>
											</fieldset>
											<fieldset <?php if(isset($_SESSION['payment_status'])){ echo 'style="display: none; position: relative; opacity: 0;"';}?>>
												<div class="form-card">
													<h2 class="fs-title">Confirm Address</h2>
													<input type="text" name="address" placeholder="Address"  value="<?php echo $address; ?>"  readonly /">														
												</div>
												<button type="button" name="previous" class="previous action-button-previous  btn btn-secondary float-left ml-4"> Back</button>
												<button type="button" name="next" class="next action-button  btn btn-secondary float-right mr-4" > Proceed</button> 
											</fieldset>
											<fieldset <?php if(isset($_SESSION['payment_status'])){ echo 'style="display: none; position: relative; opacity: 0;"';}?>>
												<div class="form-card pb-4">
													<h2 class="fs-title">Payment Mode</h2>														
													<?php 
													if (isset($_SESSION['purchase'])){
														if($_SESSION['purchase'] == "purchase"){?>
															<div class="form-group"> 
														<label for="username"><h6>Amount</h6></label> 
														<input type="text" name="amount" placeholder="Amount" readonly class="form-control " value="<?php echo $_SESSION['price']; ?>">
														<label for="username"><h6>Size</h6></label>
														<input type="text" name="size" placeholder="Size" readonly class="form-control " value="<?php echo $_SESSION['size']; ?>">
														<label for="username"><h6>Color</h6></label>
														<input type="text" name="color" placeholder="Color" readonly class="form-control " value="<?php echo $_SESSION['color']; ?>">
														
													</div>
													<div class="form-group ">
														<label for="Select Your Bank">
															<h6>Select Quantity</h6>
														</label>
														<select class="form-control" id="quantity" name="quantity">
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
														</select>
													</div>
													<input hidden id="ORDER_ID" tabindex="2" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(00000000, 99999999) ?>" readonly>
													<input hidden id="CUST_ID" tabindex="3" maxlength="12" size="25" name="CUST_ID" autocomplete="off" value="<?php echo $id; ?>" readonly>
													<input hidden id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail" readonly>
													<input hidden id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB" readonly>
													<input hidden title="TXN_AMOUNT" tabindex="6" type="text" name="TXN_AMOUNT" value="<?php echo $_SESSION['price']; ?>" readonly>
													<button type="submit" name="cash_purchase" class="button pay-button s-3 btn btn-info rounded-0 action-button p-2 w-48" ><i class="fa fa-money"></i> Cash On Dilivery</button>
													<button type="submit" name="online_purchase" class="button pay-button s-3 btn btn-info  rounded-0 action-button p-2 w-48" ><img src="images/logo/paytm.jpg" height="30" width="60" > Online(Paytm)</button>														
													<?php
														}
														if($_SESSION['purchase'] == "cart_purchase"){
															$check_cart = $db -> query("SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id INNER JOIN category ON products.categorys=category.cat_id WHERE cart.customer_id=$customer");    
															if($check_cart -> num_rows >=1){
															$total = 0;
															while($cart = $check_cart -> fetch_assoc()){
																$amount=$cart['new_price'];	
																$get_price=explode(',',$amount);			
																$size_id=$cart['size_id'];
																$subtotal = $get_price[$size_id]*$cart['quantity'];
																$total += $subtotal;
															}													
														}
														?>
															<div class="form-group"> 
																<label for="username"><h6>Amount</h6></label> 
																<input type="text" name="amount" placeholder="Amount" readonly class="form-control " value="<?php echo $total; ?>">
															</div>
															<input hidden id="ORDER_ID" tabindex="2" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(00000000, 99999999) ?>" readonly>
															<input hidden id="CUST_ID" tabindex="3" maxlength="12" size="25" name="CUST_ID" autocomplete="off" value="<?php echo $id; ?>" readonly>
															<input hidden id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail" readonly>
															<input hidden id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB" readonly>
															<input hidden title="TXN_AMOUNT" tabindex="6" type="text" name="TXN_AMOUNT" value="<?php echo $total; ?>" readonly>
															<button type="submit" name="cart_cash_purchase" class="button pay-button  s-3 btn btn-info rounded-0 action-button p-2 w-48" ><i class="fa fa-money"></i> Cash On Dilivery</button>
															<button type="submit" name="cart_online_purchase" class="button pay-button s-3 btn btn-info  rounded-0 action-button p-2 w-48" ><img src="images/logo/paytm.jpg" height="30" width="60" > Online(Paytm)</button>														
													<?php
														}
													}
													?>
												</div>
												
												<button type="button" name="previous" class="previous action-button-previous  btn btn-secondary float-left ml-4"> Back</button>
												<a href="index.php" class="button   s-3 btn btn-secondary float-left ml-4 action-button-previous float-right mr-4">Cancel order</a>
											</fieldset>

											<fieldset <?php if(isset($_SESSION['payment_status'])){ echo 'style="display: block;  opacity: 1;"';}?> >
												<div class="form-card row">
													<div class="col-md-6 " <?php if(isset($_SESSION['order_status'])){ if($_SESSION['order_status'] == "no"){ echo 'style="display: block;  opacity: 1;"';}else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Oops !</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/cancel--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>Ordered not placed</h6>
															</div>
														</div>
													</div>
													<div class="col-md-6 " <?php if(isset($_SESSION['order_status'])){ if($_SESSION['order_status'] == "yes"){ echo 'style="display: block;  opacity: 1;"';}else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Success !</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>Your Order have placed successfully</h6>
															</div>
														</div>
													</div>
													<div class="col-md-6" <?php if(isset($_SESSION['payment_status'])){ if($_SESSION['payment_status'] == "COD"){echo 'style="display: block;  opacity: 1;"'; }else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Payment</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/money--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>Cash on dilivery</h6>
															</div>
														</div>
													</div>
													<div class="col-md-6" <?php if(isset($_SESSION['payment_status'])){ if($_SESSION['payment_status'] == "cancelled"){ echo 'style="display: block;  opacity: 1;"';}else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Payment</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/cancel--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>You have cancelled the Transaction</h6>
															</div>
														</div>
													</div>
													<div class="col-md-6" <?php if(isset($_SESSION['payment_status'])){ if($_SESSION['payment_status'] == "ok"){echo 'style="display: block;  opacity: 1;"'; }else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Payment</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>Transaction is successful</h6>
															</div>
														</div>
													</div>													
													<div class="col-md-6" <?php if(isset($_SESSION['payment_status'])){ if($_SESSION['payment_status'] == "failed"){echo 'style="display: block;  opacity: 1;"'; }else{ echo 'style="display: none;';}}?>>
														<h2 class="fs-title text-center">Payment</h2> <br>
														<div class="row justify-content-center">
															<div class="col-3"> <img src="https://img.icons8.com/color/96/000000/cancel--v2.png" class="fit-image"> </div>
														</div> <br>
														<div class="row justify-content-center">
															<div class="col-12 text-center">
																<h6>Transaction was unsuccessful</h6>
															</div>
														</div>
													</div>
													<div class="col-12 text-center mt-2 border-top pt-2">
														<h6>Check your order <a href="orders.php" class="btn btn-success">My Order</a></h6>
													</div>
												</div>
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- -->
			</main>
		</div>
	</section>
	<!-- Footer -->
	<?php include 'footer.php'; ?>
</body>

</html>
<?php unset($_SESSION['payment_status']); $db = $database->close();
} ?> 