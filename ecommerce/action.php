<?php
session_start();
include "dbconfig/dbconfig.php";
$db=$database->open();
//login
if (isset($_POST['login'])) {	
	$email=$_POST['email'];
	$pass=$_POST['password'];
	$password=sha1($pass);
	$login = $db -> query("SELECT * FROM customers WHERE email='$email' AND passwords='$password'");
	if ($login -> num_rows > 0) {
		$user = $login -> fetch_assoc();
		$_SESSION['id']=$user['id'];
		$_SESSION['email']=$user['email'];
        $_SESSION['name']=$user['names'];
        $_SESSION['image']=$user['image'];
        header("location:index.php");	
	}
	else{
		$message='<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Email or Password dosent match!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
        $_SESSION['message']=$message;
        header("location:index.php");
	}
}
//add to cart
if (isset($_POST['add_cart'])) {
    $customer = $_SESSION['id'];
    $item_in=$_POST['item_in'];
    $item=$_POST['item'];
    $id = base64_decode($item);
    $color=$_POST['color'];
    $quantity=1;
    $size=$_POST['size_id'];
    $check_cart = $db -> query("SELECT * FROM cart WHERE customer_id=$customer && product_id=$id");    
    if($check_cart -> num_rows >= 1){
        $message='<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                    <strong><i class="fa fa-warning"></i></strong> Item already added to cart!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>';
        $_SESSION['cart_message'] = $message;
        header("location:product_details.php?items=$item&items_in=$item_in");
    }else{
        $cart = $db -> query("INSERT INTO cart(customer_id,product_id,size_id,cart_color,quantity)VALUES($customer,$id,$size,'$color',$quantity)");
        if($cart){
            $message='<div class="alert alert-success alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                        <strong><i class="fa fa-check"></i></strong> Item added to cart!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>';
            $_SESSION['cart_message'] = $message;
            header("location:product_details.php?items=$item&items_in=$item_in");
        }
        else{
            $message='<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                        <strong><i class="fa fa-warning"></i></strong> Something went wrong!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>';
            $_SESSION['cart_message'] = $message;
            header("location:product_details.php?items=$item&items_in=$item_in");
        }
    }
}
//remove item from cart
if (isset($_POST['cart_id'])){	
    $id = $_POST['cart_id'];
    $remove_cart = $db -> query("DELETE FROM cart WHERE cart_id = $id");
}

//count cart item
if (isset($_POST['cart'])) {
    if (isset($_SESSION['id'])) {
        $customer = $_SESSION['id'];
        $check_cart = $db -> query("SELECT count(cart_id) FROM cart WHERE customer_id=$customer");    
        if($check_cart -> num_rows >= 1){
            $cart = $check_cart -> fetch_row();
            $total=$cart[0];
            echo $total;
        }
    }
}
//update quantity to cart
if ((isset($_POST['quantity_cart_id'])) && (isset($_POST['cart_value']))) {
    if (isset($_SESSION['id'])) {
        $id = $_POST['quantity_cart_id'];
        $quantity = $_POST['cart_value'];
        $update_quantity = $db -> query("UPDATE cart SET quantity='$quantity' WHERE cart_id='$id'");
    }
}
//cart total
if(isset($_POST['cart_total'])){
    $customer = $_SESSION['id'];
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
        echo '<div  class="text-left col-6">Total Amount</div>
        <div class=" col-6 text-right"><i class="fa fa-rupee"></i> '.$total.'</div>';
    }else{
        echo '<p  class="text-center text-danger"><i class="pe-7s-cart" style="font-size: 40px;"></i><br/> No cart item found, Please add items to cart!</p>';
    }
}

if(isset($_POST['purchase'])){
    $customer = $_SESSION['id'];
    $item=$_POST['item'];
    $item_in=$_POST['item_in'];
    $id = base64_decode($item); 
    $_SESSION['item_id'] = $id;   
    $get_product = $db ->query("SELECT * FROM products WHERE product_id = $id");
    if($get_product -> num_rows ==1){
        $row = $get_product -> fetch_assoc();
        $color=$_POST['color'];
        $_SESSION['color'] = $color;
        $size_id=$_POST['size_id'];
        $amount=$row['new_price'];	
        $get_price = explode(',',$amount);			
        $price = $get_price[$size_id];
        $size = $row['product_size'];	
        $get_size = explode(',',$size);			
        $sizes = $get_size[$size_id];
        $_SESSION['price'] = $price;
        $_SESSION['size'] = $sizes;
        $_SESSION['purchase'] = "purchase";
        header("location:order_process.php");            
    }
    else{
        header("location:product_details.php?items=$item&items_in=$item_in");
    }
}
if(isset($_POST['cart_purchase'])){
    $customer = $_SESSION['id'];
    $_SESSION['purchase'] = "cart_purchase";
    header("location:order_process.php");
}
//logout user
if (isset($_POST['logout'])) {
    if (isset($_SESSION['id'])) {
        session_destroy();
        header("location:index.php");
    }
}
$db=$database->close();
?>