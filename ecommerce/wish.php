<?php
session_start();
include "dbconfig/dbconfig.php";
$db=$database->open();
if(isset($_POST['wishlist'])){
    $id = $_POST['wishlist']; 
    $customer = $_SESSION['id'];
    $check_wish = $db -> query("SELECT * FROM wish WHERE customer_id=$customer && item_id=$id");    
    if($check_wish -> num_rows >=1){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                    <strong><i class="fa fa-warning"></i></strong> Item already added<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>';       
    }else{
        $wish = $db -> query("INSERT INTO wish(customer_id,item_id) VALUES($customer,$id)");
        if($wish){
            echo '<div class="alert alert-success alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                            <strong><i class="fa fa-check"></i></strong> Item added to your Wishlist<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>';
        }else {
	        echo '<div class="alert alert-danger alert-dismissible fade show mb-1 mt-1 mr-2" role="alert">
                        <strong><i class="fa fa-warning"></i></strong> Item not added to wishlist!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>';
        }
    }
}
$db=$database->close();
?>