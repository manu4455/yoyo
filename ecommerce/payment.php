<?php
    session_start();
    date_default_timezone_set('Asia/kolkata');
    include "dbconfig/dbconfig.php";
    include "link.php";
    $db = $database->open();
    $customer_id = $_SESSION['id'];
    $send_to = $_SESSION['email'];
    $name = $_SESSION['name'];   
    
    //Singl COD purchase
    if(isset($_POST['cash_purchase'])){
      $id = $_SESSION['item_id'];
      $size = $_POST['size'];
      $color = $_POST['color'];
      $quantity = $_POST['quantity'];
      $ORDER_ID = $_POST["ORDER_ID"];
      $_SESSION['order_id'] = $ORDER_ID;     
      $CUST_ID = $_POST["CUST_ID"];       
      $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
      $amount = $TXN_AMOUNT*$quantity;
      $pay = "Not-Paid";
      $paid_by="COD";
      $status = 1;
      $dates = date("d-m-Y h:i:s a");
      $date = strtotime($dates);
      $order = $db -> query("INSERT INTO orders(order_id,customer_id,product_id,size,order_color,quantity,amount,total_amount,payment,payment_mode) VALUES('$ORDER_ID',$CUST_ID,$id,'$size','$color',$quantity,$TXN_AMOUNT,$amount,'$pay','$paid_by')");
      if($order){
       $message = "";
       $order_status = $db -> query("INSERT INTO order_progress(order_id,status_id,date) VALUES('$ORDER_ID',$status,'$date')");
       $message .= '<table class="table table-bordered table-striped bg-primary" border="1" >
          <thead>
            <tr>
              <th colspan="4">'.$ORDER_ID.'	<span>( Cash On Dilivery )</span> <span class="float-right text-capitalize"> '.$name.'</span></th>
            </tr>
            <tr class="text-center">
              <th>Name</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Amount</th>
            </tr>								
          </thead>
          <tbody class="text-center">';
          $check_order = $db -> query("SELECT * FROM orders INNER JOIN products ON orders.product_id=products.product_id  WHERE  orders.order_id='$ORDER_ID'");    
          while($order = $check_order -> fetch_assoc()){
          $total_price = $order['quantity'] * $order['amount']; 
          $message .= '<tr>
              <td>'.$order['product_name'].'</td>
              <td>'.$order['size'].'</td>
              <td>'.$order['quantity'].'</td>
              <td>'.$order['amount'].'</td>
            </tr>';
          } 
          $message .='</tbody>
          <tfoot>
            <tr>
              <th colspan="3"> Cash on Dilivery</th>
              <th> '.$total_price.' /-</th>
            </tr>
            <tr class="text-center">
              <th colspan="4">Thank you for shopping with us. Team <a href="../../shop/users/"> Sneekers</a></th>
            </tr>
          </tfoot>
        </table>';
        //$subject = "Order Confirmation";
        // $mail->addAddress($send_to); 

        // // Content
        // $mail->isHTML(true);                    
        // $mail->Subject = 'Order Confirmation';
        // $mail->Body    = $message;
       
        // $mail->send();
        $_SESSION['order_status']="yes";
        $_SESSION['payment_status']="COD";
        header("location:order_process.php");       
      }
      else{
        $_SESSION['order_status']="no";
        header("location:order_process.php");
      }     
    }

    //Singl online purchase
    if(isset($_POST['online_purchase'])){
        $id = $_SESSION['item_id'];
        $size = $_POST['size'];
        $color = $_POST['color'];
        $quantity = $_POST['quantity'];
        $ORDER_ID = $_POST["ORDER_ID"];
        $_SESSION['order_id'] = $ORDER_ID;
        $CUST_ID = $_POST["CUST_ID"];
        $_SESSION['cust_id'] = $CUST_ID;
        $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
        $_SESSION['industry_id'] = $INDUSTRY_TYPE_ID;
        $CHANNEL_ID = $_POST["CHANNEL_ID"];
        $_SESSION['channel'] = $CHANNEL_ID;
        $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
        $amount = $TXN_AMOUNT*$quantity;
        $_SESSION['txn_amount'] = $amount ;
        $pay = "Not-Paid";
        $paid_by="Online";
        $order_status = "Order Placed";
        $dates = date("d-m-Y h:i:s a");
        $date = strtotime($dates);
        $order = $db -> query("INSERT INTO orders(order_id,customer_id,product_id,size,order_color,quantity,amount,total_amount,payment,order_status,payment_mode,order_date) VALUES('$ORDER_ID',$CUST_ID,$id,'$size','$color',$quantity,$TXN_AMOUNT,$amount,'$pay','$order_status','$paid_by',$date)");
        if($order){
          header("location:paytm/PaytmKit/pgRedirect.php");
        }
        else{
          $_SESSION['order_status']="no";
          header("location:order_process.php");
       }  
    }

    // Purchase from cart by COD
    if(isset($_POST['cart_cash_purchase'])){
      $ORDER_ID = $_POST["ORDER_ID"];
      $_SESSION['order_id'] = $ORDER_ID;
      $CUST_ID = $_POST["CUST_ID"];
      $_SESSION['cust_id'] = $CUST_ID;
      $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
      $_SESSION['industry_id'] = $INDUSTRY_TYPE_ID;
      $CHANNEL_ID = $_POST["CHANNEL_ID"];
      $_SESSION['channel'] = $CHANNEL_ID;
      $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
      $_SESSION['txn_amount'] = $TXN_AMOUNT ;
      $pay = "Not-Paid";
      $paid_by="COD";
      $status = 1;
      $dates = date("d-m-Y h:i:s a");
      $date = strtotime($dates);
      $check_cart = $db -> query("SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id INNER JOIN category ON products.categorys=category.cat_id WHERE cart.customer_id=$customer_id");    
      if($check_cart -> num_rows >=1){
        while($cart = $check_cart -> fetch_assoc()){
          $color = $cart['cart_color'];
          $item_id = $cart['cart_id'];
          $quantity =  $cart['quantity'];
          $size_id=$cart['size_id'];
          $id = $cart['product_id'];
          $amount=$cart['new_price'];	
          $get_price=explode(',',$amount);			
          $amt = $get_price[$size_id];
          $total_amt = $get_price[$size_id]*$cart['quantity'];
          $size=$cart['product_size'];	
          $get_size=explode(',',$size);			
          $sizes = $get_size[$size_id];
          $order = $db -> query("INSERT INTO orders(order_id,customer_id,product_id,size,order_color,quantity,amount,total_amount,payment,payment_mode) VALUES('$ORDER_ID',$CUST_ID,$id,'$sizes','$color',$quantity,$amt,$total_amt,'$pay','$paid_by')");
          $delete = $db -> query("DELETE FROM cart WHERE cart_id = $item_id");
        }
        $order_status = $db -> query("INSERT INTO order_progress(order_id,status_id,date) VALUES('$ORDER_ID',$status,'$date')");
        $_SESSION['order_status']="yes";
        $_SESSION['payment_status']="COD";
        header("location:order_process.php");
        
      }

    }

    // Purchase from cart by online
    if(isset($_POST['cart_online_purchase'])){
      $ORDER_ID = $_POST["ORDER_ID"];
      $_SESSION['order_id'] = $ORDER_ID;
      $CUST_ID = $_POST["CUST_ID"];
      $_SESSION['cust_id'] = $CUST_ID;
      $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
      $_SESSION['industry_id'] = $INDUSTRY_TYPE_ID;
      $CHANNEL_ID = $_POST["CHANNEL_ID"];
      $_SESSION['channel'] = $CHANNEL_ID;
      $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
      $_SESSION['txn_amount'] = $TXN_AMOUNT ;
      $pay = "Not-Paid";
      $paid_by="Online";
      $order_status = "Order Placed";
      $dates = date("d-m-Y h:i:s a");
      $date = strtotime($dates);
      $check_cart = $db -> query("SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id INNER JOIN category ON products.categorys=category.cat_id WHERE cart.customer_id=$customer_id");    
      if($check_cart -> num_rows >=1){
        while($cart = $check_cart -> fetch_assoc()){
          $color = $cart['cart_color'];
          $item_id = $cart['cart_id'];
          $quantity =  $cart['quantity'];
          $size_id=$cart['size_id'];
          $id = $cart['product_id'];
          $amount=$cart['new_price'];	
          $get_price=explode(',',$amount);			
          $amt = $get_price[$size_id];
          $total_amt = $get_price[$size_id]*$cart['quantity'];
          $size=$cart['product_size'];	
          $get_size=explode(',',$size);			
          $sizes = $get_size[$size_id];
          $order = $db -> query("INSERT INTO orders(order_id,customer_id,product_id,size,order_color,quantity,amount,total_amount,payment,order_status,payment_mode,order_date) VALUES('$ORDER_ID',$CUST_ID,$id,'$sizes','$color',$quantity,$amt,$total_amt,'$pay','$order_status','$paid_by',$date)");
          $delete = $db -> query("DELETE FROM cart WHERE cart_id = $item_id");
        }	
        header("location:paytm/PaytmKit/pgRedirect.php");
      }
    }

  // $order_placed = "Order Placed: Your order for name with order ID worth Rs.222 has been received";
	$db = $database->close();
?>