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
                    <a href="index.php" class="btn btn-default navigator rounded-0"><i class="fa fa-home"> Home</i></a>
                </div>
            </div>
            <section class="main mt-2">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 ">
                                <div class="card  dashboard-card">
                                    <div class="card-header dashboard-card-header">New Orders</div>
                                    <div class="card-body row dashboard-card-body">
                                        <div class="col-8 text-center dashboard-card-logo"><i class="fa fa-first-order"></i></div>
                                        <div class="col-4 text-center dashboard-card-text">
                                            <span>
                                                <?php
                                                $s=1;
                                                $result_db = $db -> query("SELECT COUNT(id) FROM  orders WHERE new = 1"); 
                                                $row_db = $result_db -> fetch_row();  
                                                echo $total_records = $row_db[0]; 
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right dashboard-card-footer">
                                      <a href="new_order.php">More <i  class="fa fa-arrow-right btn btn-primary"></i></a></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 ">
                                <div class="card  dashboard-card">
                                    <div class="card-header dashboard-card-header">Total Orders</div>
                                    <div class="card-body row dashboard-card-body">
                                        <div class="col-8 text-center dashboard-card-logo"><i class="fa fa-first-order"></i></div>
                                                <div class="col-4 text-center dashboard-card-text">
                                            <span>
                                                <?php
                                                $result_db = $db -> query("SELECT COUNT(id) FROM  orders "); 
                                                $row_db = $result_db -> fetch_row();  
                                                echo $total_records = $row_db[0]; 
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right dashboard-card-footer">
                                      <a href="all_order.php">More <i class="fa fa-arrow-right btn btn-primary"></i></a></div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 ">
                                <div class="card  dashboard-card">
                                    <div class="card-header dashboard-card-header">Consumers</div>
                                    <div class="card-body row dashboard-card-body">
                                        <div class="col-8 text-center dashboard-card-logo"><i class="fa fa-users"></i>
                                        </div>
                                        <div class="col-4 text-center dashboard-card-text">
                                            <span>
                                                <?php
                                                $result_db = $db -> query("SELECT COUNT(id) FROM  customers "); 
                                                $row_db = $result_db -> fetch_row();  
                                                echo $total_records = $row_db[0]; 
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right dashboard-card-footer">
                                      <a href="consumers.php">More <i class="fa fa-arrow-right btn btn-primary"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 ">
                                <div class="card  dashboard-card">
                                    <div class="card-header dashboard-card-header">All Items</div>
                                    <div class="card-body row dashboard-card-body">
                                        <div class="col-8 text-center dashboard-card-logo"><i
                                                class="fa fa-product-hunt"></i></div>
                                        <div class="col-4 text-center dashboard-card-text">
                                            <span>
                                                <?php
                                                $result_db = $db -> query("SELECT COUNT(product_id) FROM  products "); 
                                                $row_db = $result_db -> fetch_row();  
                                                echo $total_records = $row_db[0]; 
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right dashboard-card-footer">
                                      <a href="product_summary.php">More <i class="fa fa-arrow-right btn btn-primary"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4 ">
                                <div class="card  dashboard-card">
                                    <div class="card-header dashboard-card-header">Package & Dilivery</div>
                                    <div class="card-body row dashboard-card-body">
                                        <div class="col-6 text-center dashboard-card-logo"><i class="fa fa-gift"></i></div>
                                        <div class="col-6 text-center dashboard-card-text"><i class="fa fa-car"></i></div>
                                    </div>
                                    <div class="card-footer row text-right dashboard-card-footer  text-dark">
                                        <div class="col-6 text-center dashboard-card-logo text-dark"><a href="scan.php"><i class="fa fa-scope"> </i> Scan</a></div>
                                        <div class="col-6 text-center dashboard-card-text text-dark"><a href="package.php"><i class="fa fa-scope"> </i> Enter ID</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <form method="POST" action="logout.php">
                    <button type="submit" class="btn btn-secondary" name="logout"> <i class="fa fa-sign-out"></i> Logout</button>
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