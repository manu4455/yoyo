<?php 
include 'dbconfig/dbconfig.php';
$db = $database->open();
//Country Management 
if(!empty($_POST["countrycheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["countrycheck"];
    $s=1;
    $result = $db->query("UPDATE country SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
if(!empty($_POST["countryuncheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["countryuncheck"];
    $s=0;
    $result = $db->query("UPDATE country SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
//State Management
if(!empty($_POST["statecheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["statecheck"];
    $s=1;
    $result = $db->query("UPDATE states SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
if(!empty($_POST["stateuncheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["stateuncheck"];
    $s=0;
    $result = $db->query("UPDATE states SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
//City Management
if(!empty($_POST["citycheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["citycheck"];
    $s=1;
    $result = $db->query("UPDATE city SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
if(!empty($_POST["cityuncheck"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["cityuncheck"];
    $s=0;
    $result = $db->query("UPDATE city SET status = '$s' WHERE id=$id");
    // Generate HTML of state options list 
    if($result){ 
       echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-check"></i></strong> Success!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    }else{ 
         echo '<div class="alert alert-warning alert-dismissible fade show mb-1 mt-1" role="alert">
                <strong><i class="fa fa-warning"></i></strong> Alert! Opps something went wrong <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>';
    } 
}
?>