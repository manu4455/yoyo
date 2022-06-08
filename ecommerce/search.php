<?php
include "dbconfig/dbconfig.php";
$db=$database->open();
if(isset($_POST["search"])){
    $search = $_POST["search"];
    $sql = $db -> query("SELECT * FROM category WHERE category_name LIKE '%$search%' ");
    if($sql -> num_rows > 0){
        while($row = $sql -> fetch_assoc()){
            echo '<p class="result">'. $row["category_name"].'</p>' ;
        }
    } else{
        echo "<p class='result'>No Result Found !</p>";
    }
}
if(!empty($_POST["country_id"])){ 
    // Fetch state data based on the specific country 
    $id=$_POST["country_id"];
    $result = $db->query("SELECT * FROM states WHERE c_id = $id AND status=1 ORDER BY state_name ASC");
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select State</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['id'].'">'.$row['state_name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">State not available</option>'; 
    } 
}
if(!empty($_POST["state_id"])){ 
    // Fetch city data based on the specific state
    $id = $_POST["state_id"];
    $query = "SELECT * FROM city WHERE s_id = $id AND status=1 ORDER BY city_name ASC"; 
    $result = $db->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select city</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['id'].'">'.$row['city_name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">City not available</option>'; 
    } 
} 
?>