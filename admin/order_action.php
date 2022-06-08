<?php
session_start();
include "dbconfig/dbconfig.php";
$db=$database->open();
date_default_timezone_set('Asia/kolkata');
$dates = date("d-m-Y h:i:s a");
$date = strtotime($dates);
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <montoshrai8@gmail.com>' . "\r\n";

$items ="";
if (isset($_POST['received'])) {
    $id = $_POST['received'];
    $r=1;
	$n=0;
	$status = 2;
	$order = $db -> query("UPDATE orders SET received=$r, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
	
	if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$status ="Order Received";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>WE HAVE RECEIVED YOUR ORDER</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.',  You will receive another mail when your order packed and ready to dispatched</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order received</strong></span>
			</div>';
			}
			else{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order received</strong></span>
			</div>';
			}
		}else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Order received</strong></span>
		</div>';
		}
		
       
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong> Order not received,Please Try Again</strong></span>
	  </div>';
    }    
}
if (isset($_POST['packed'])) {
    $id = $_POST['packed'];
    $r=1;
	$n=0;
	$status = 3;
	$order = $db -> query("UPDATE orders SET packed=$r, received=$n, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
    if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$subject ="Order Packed";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>YOUR ORDER HAS BEEN PACKED AND READY TO DISPATCHED '.$dates.'</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.',  You will receive another mail when your order dispatched for Dilivery</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Packed</strong></span>
			</div>';
			}else{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Packed</strong></span>
			</div>';
			}
		}else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Order Packed</strong></span>
		  </div>';
		}
       
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong> Order not Packed, Please Try Again</strong></span>
	  </div>';
    }    
}
if (isset($_POST['shipped'])) {
    $id = $_POST['shipped'];
    $r=1;
	$n=0;
	$status = 4;
	$order = $db -> query("UPDATE orders SET shipped=$r,packed=$n,received=$n, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
    if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$subject ="Order Dispatched";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>YOUR ORDER HAS BEEN DISPATCHED ON '.$dates.'</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.',  You will receive Your order soon</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Shipped</strong></span>
			</div>';
			}else{
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Shipped</strong></span>
			</div>';
			}
		}else{
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Shipped</strong></span>
			</div>';
		}
        
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong> Order not Shipped, Please Try Again</strong></span>
	  </div>';
    }    
}
if (isset($_POST['cod-dilevered'])) {
    $id = $_POST['cod-dilevered'];
    $r=1;
	$n=0;
	$status = 5;
	$order = $db -> query("UPDATE orders SET payment='Paid',dilivered=$r ,shipped=$n ,packed=$n ,received=$n, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
    if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$subject ="Order Dilivered";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>ORDER DILIVERED SUCCESSFULLY</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.', Your order has dilivered on '.$dates.'</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
			</div>';
			}
			else{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
		  </div>';
			}
		}else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
	  </div>';
		}
        
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong> Order not Dilevered, Some Server error, Please Try Again</strong></span>
	  </div>';
    }    
}
if (isset($_POST['online-dilevered'])) {
    $id = $_POST['online-dilevered'];
    $r=1;
	$n=0;
	$status = 5;
	$order = $db -> query("UPDATE orders SET payment='Paid', dilivered=$r ,shipped=$n, packed=$n, received=$n, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
    if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$subject ="Order Dilivered";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>ORDER DILIVERED SUCCESSFULLY</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.', Your order has dilivered on '.$dates.'</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
			</div>';
			}else{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
			  </div>';
			}
		}
		else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
		  </div>';
		}
       
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong>  Order not Dilevered, Some Server error, Please Try Again</strong></span>
	  </div>';
    }    
}
if (isset($_POST['online-dilevered-pay'])) {
    $id = $_POST['online-dilevered-pay'];
    $r=1;
	$n=0;
	$status = 5;
	$order = $db -> query("UPDATE orders SET payment='Paid' dilivered=$r shipped=$n packed=$n received=$n, new = $n WHERE order_id='$id'");
	$order_prog = $db -> query("INSERT INTO  order_progress(order_id,status_id,date) VALUES ('$id',$status,$date)");    
    if($order && $order_prog){
		$get_mail_id =$db ->query("SELECT C.email,C.names,P.product_name,O.size,O.order_color,O.total_amount from customers C INNER JOIN orders O ON C.ID=O.customer_id INNER JOIN products P ON P.product_id=O.product_id WHERE O.order_id='$id'");
		if ($get_mail_id ->num_rows >=1) {
			while($row= $get_mail_id->fetch_assoc()){
				$email = $row['email'];
				$name =$row['names'];
				$items .='<tr style="text-align:center;"><td style="text-align:left;">'.$row['product_name'].'</td><td>'.$row['size'].'</td><td>'.$row['order_color'].'</td><td>'.$row['total_amount'].'</td></tr>';
			}
			$subject ="Order Dilivered";
			$mail_body ='<body>
				<div style="text-align:center;">
					<h4>ORDER DILIVERED SUCCESSFULLY</h4>
				</div>
				<div style="text-align:justify;margin-top: 5px;font-weight:500;">
					<table style="width:100%;">
						<thead><tr style="text-align:center;"><th style="text-align:left;">Item Name</th><th>Size</th><th>Color</th><th>Price</th></tr></thead>
						<tbody>'.$items.'</tbody>
					</table>
				</div>
				<div style="text-align:justify;margin-top: 5px; font-weight: bold;">
					<p>Thanks You for shopping with us  '.$name.', Your order has dilivered on '.$dates.'</p>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:10px;background-color:#104680; color:white; border-radius:20px;">
					Order Id <h5>'.$id.'</h5>
				</div>
				<div style="text-align:center;margin-top: 5px; width:100%;paddig:20px;background-color:blue; color:black; border-radius:20px;">
					<a href="tracking.php?track_order="'.$id.'" style=" color: white; border-radius:20px;">TRACK ORDER</a>
				</div>
			</body>';
			if(mail($email,$subject,$mail_body,$headers)){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
			</div>';
			}
			else{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
		  </div>';
			}
		}
		else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-check"> Success</i> <span><strong>Order Dilevered Successfully</strong></span>
	  </div>';
		}
        
    }else{
       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error</i> <span><strong>  Order not Dilevered, Some Server error, Please Try Again</strong></span>
	  </div>';
    }    
}

$db=$database->close();
?>