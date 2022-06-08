<?php
session_start();
if(!isset($_SESSION['admin_email']) && ($_SESSION['admin_email']))
{ 
	header("location:index.php");
}else{
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin | Panel</title>
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
                    <a href="package.php" class="btn btn-default navigator rounded-0"><i class="fa fa-car"> Package & Dilivery</i></a>
                </div>
            </div>
            <section class="main mt-2">
                <div class="container-fluid">
                <div id="message"></div>
                    <div class="col-md-12 card pb-3 pt-3">
                        <form method="POST">
                            <div class="row ">
                                <div class="col-8">                           
                                    <input type="text" name="product-id"  class="form-control rounded">
                                </div>
                                <div class="col-4">
                                    <input type="submit" name="search-product"  class="btn btn-primary w-100" value="Search">
                                </div>                                                        
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="main mt-2">
                <div class="container-fluid">
                    <div class="col-md-12 card pb-3 pt-3">
                        <form method="POST">                 
                            <div class="col-12"> 
                            <?php
                            $order_id = "";
                            if(isset($_POST['search-product'])){
                                $order_id =$_POST['product-id'];
                                $order = $db -> query("SELECT * FROM `orders` WHERE order_id='$order_id'");
                                if ($order ->num_rows >=1) {
                                    $row= $order->fetch_assoc();
                                    if (($row['received']==1) && ($row['packed']==0) && ($row['shipped']==0) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                       echo '<a href="" id="'.$order_id.'"  class="btn btn-primary w-100 packed-order" >Packed</a>';
                                    }
                                    if (($row['packed']==1) && ($row['shipped']==0) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                        echo '<a href="" id="'.$order_id.'"  class="btn btn-primary w-100 shipped-order">Shipped</a>';
                                    }
                                    if (($row['shipped']==1) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                        if(($row['payment_mode']=="COD") && ($row['payment']=="Not-Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>PLease Receive Cash from Customer</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 cod-dilevered" >Dilivered</a>';
                                        }
                                        if(($row['payment_mode']=="ONLINE") && ($row['payment']=="Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>Payment already Made By Online</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 online-dilevered" >Dilivered</a>';     
                                        }
                                        if(($row['payment_mode']=="ONLINE") && ($row['payment']=="Not-Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>PLease Receive Cash from Customer</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 online-dilevered-pay">Dilivered</a>';     
                                        }
                                        
                                    }
                                    if (($row['dilivered']==1) && ($row['cancel']==0)) {
                                        echo '<div class="alert alert-success" role="alert"><strong>This item has already been dilivered</strong></div>';
                                    }
                                    if (($row['cancel']==1)) {
                                        echo '<div class="alert alert-danger" role="alert"><strong>This item has already been Cancelled</strong></div>';
                                    }
                                }else{
                                    echo '<div class="alert alert-danger" role="alert"><strong>The item does not exists</strong></div>'; 
                                }
                            }elseif (isset($_GET['order_id'])) {
                                $order_id =$_GET['order_id'];
                                $order = $db -> query("SELECT * FROM `orders` WHERE order_id='$order_id'");
                                if ($order ->num_rows >=1) {
                                    $row= $order->fetch_assoc();
                                    if (($row['received']==1) && ($row['packed']==0) && ($row['shipped']==0) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                       echo '<a href="" id="'.$order_id.'"  class="btn btn-primary w-100 packed-order" >Packed</a>';
                                    }
                                    if (($row['packed']==1) && ($row['shipped']==0) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                        echo '<a href="" id="'.$order_id.'"  class="btn btn-primary w-100 shipped-order">Shipped</a>';
                                    }
                                    if (($row['shipped']==1) && ($row['dilivered']==0) && ($row['cancel']==0)) {
                                        if(($row['payment_mode']=="COD") && ($row['payment']=="Not-Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>PLease Receive Cash from Customer</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 cod-dilevered" >Dilivered</a>';
                                        }
                                        if(($row['payment_mode']=="ONLINE") && ($row['payment']=="Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>Payment already Made By Online</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 online-dilevered" >Dilivered</a>';     
                                        }
                                        if(($row['payment_mode']=="ONLINE") && ($row['payment']=="Not-Paid")){
                                            echo '<div class="alert alert-success" role="alert"><strong>PLease Receive Cash from Customer</strong></div><br>';
                                            echo '<a href="" id="'.$order_id.'" class="btn btn-primary w-100 online-dilevered-pay">Dilivered</a>';     
                                        }
                                        
                                    }
                                    if (($row['dilivered']==1) && ($row['cancel']==0)) {
                                        echo '<div class="alert alert-success" role="alert"><strong>This item has already been dilivered</strong></div>';
                                    }
                                    if (($row['cancel']==1)) {
                                        echo '<div class="alert alert-danger" role="alert"><strong>This item has already been Cancelled</strong></div>';
                                    }
                                }else{
                                    echo '<div class="alert alert-danger" role="alert"><strong>The item does not exists</strong></div>'; 
                                }
                               
                            }
                            
                            ?>                          
                                
                            </div>                                                        
                            
                        </form>
                    </div>
                </div>
            </section>
        
        </div>
    </div>    
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
                    <button type="button" class="btn btn-secondary" name="logout"> <i class="fa fa-sign-out"></i> Logout</button>
                    <a href="account.php" class="btn btn-primary"> <i class="fa fa-user"></i> Account</a>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <?php include "js/script.php"; ?>
</body>

</html>
<?php 
$db = $database->close();
}
?>