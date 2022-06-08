<?php
session_start();
include 'dbconfig/dbconfig.php';
$db = $database->open();
//Add brand                              
if(isset($_POST['add_brand'])){
    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['brand'])) {
        $_SESSION['brand_name'] = ' Brand name error ';
        header('location: brand.php');	
    }
    else{
        $brand_name=$_POST['brand'];
        if(!empty($brand_name)){
        $insert=$db->query("INSERT INTO brand (brand_name) VALUES ('$brand_name')");
            if($insert){
                $_SESSION['message'] = '<span class="text-success">Brand added successfully</span>';
                header('location: brand.php'); 
            }
            else{
                $_SESSION['message'] = '<span class="text-danger">Brand not addad </span>';
                header('location: brand.php'); 
            }
        }
        else{
            $_SESSION['message'] = '<span class="text-danger">Brand not addad</span>';
            header('location: brand.php');
        }
    }
}
//Add category
if (isset($_POST['add_category'])) {
    if(!empty($_POST['category'])){
      $parent_category=$_POST['category'];
    }
    else{
      $parent_category = 0;
    }
    if(empty($_POST["catname"])){
      $_SESSION['cat_name'] = "Please enter name of category";
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$_POST["catname"] )) {
      $_SESSION['cat_name'] = "Invalid category Name";
    }
    else{
      $category_name=$_POST["catname"];
    }
    if(!empty($_FILES["image"]["name"])){
      $type =pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
      $name =pathinfo($_FILES["image"]["name"],PATHINFO_FILENAME);
      $temp=$_FILES["image"]["tmp_name"];
      $validatefile = array("jpeg","jpg","png");
      if ($_FILES["image"]["size"] > 500000) {
        $_SESSION['image'] = "Sorry, your image is too large.";
      }
      if(!in_array($type, $validatefile)) {
          $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
      }
      if(($_FILES["image"]["size"] < 500000) && (in_array($type, $validatefile)))
      {
        $images=$_FILES["image"]["name"];
        $path = "../images/category/";
        $target_file = $path.$images;
        if (file_exists($target_file)) {
          $renmae=rand(100,999);
          $move_to = $path.$name.$renmae.'.'.$type;
          $image=$name.$renmae.'.'.$type;
        }
        else{
          $move_to = $path.$images;
          $image=$images;
        }
        move_uploaded_file($temp, $move_to);
      }
    }
    else{
      $image="no.jpeg";
    }
    if((!empty($category_name)) && (!empty($image))){
      $insert=$db->query("INSERT INTO category(parent_id,category_name,image) VALUES ('$parent_category','$category_name','$image')");
      if($insert){
          $_SESSION['message'] = '<span class="text-success">Category added successfully</span>';
          header('location: category.php'); 
      }
      else{
          $_SESSION['message'] = '<span class="text-danger">Category not addad </span>';
          header('location: category.php'); 
      }
    }
    else{
        $_SESSION['message'] = '<span class="text-danger">Category not addad</span>';
        header('location: category.php');      
    }
}
if (isset($_POST['add_product'])) {
  $category_id=$_POST['category'];
  $brand_id=$_POST['brand'];
  if (!preg_match("/^[a-zA-Z ]*$/",$_POST["name"] )) {
    $_SESSION['product_name'] = "Invalid Product Name";
  }
  else{
    $product_name=$_POST["name"];
  }
  $description=$_POST["description"];
  $size=implode(',',$_POST["size"]);
  $color=implode(',',$_POST["color"]);
  $stock=implode(',',$_POST["stock"]);
  $newprice=implode(',',$_POST["newprice"]);
  $price=explode(',',$newprice);
  $count=count($price);
  $p=array();
  for ($i=0; $i < $count  ; $i++) {
    $p[$i]=0;
    $oldprice=implode(',',$p);
  }  
  if(!empty(array_filter($_FILES['image']['name']))){
    echo "yes";
    $validatefile = array("jpeg","jpg","png");
    $up_image = array();
    foreach($_FILES['image']['name'] as $p_img => $image_name){
      $type = pathinfo($image_name, PATHINFO_EXTENSION);
      $name = pathinfo($image_name, PATHINFO_FILENAME);
      if ($_FILES['image']['size'][$p_img] > 5000000) {
        $_SESSION['image'] = "Sorry, your image is too large.";
      }
      if(!in_array($type, $validatefile)) {
        $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
      }
      if(($_FILES['image']['size'][$p_img] <= 5000000) && in_array($type, $validatefile)){
        echo "no";
        $path = "../images/items/";
        $file_exits = $path.$image_name;
        if (file_exists($file_exits)) {          
          $re_name=rand(10,99);
          $move_to = $path.$name.$re_name.'.'.$type;
          $up_image[].=$name.$re_name.'.'.$type;
          move_uploaded_file($_FILES['image']['tmp_name'][$p_img],$move_to);
        }
        else{
          $up_image[].=$image_name;
          $move_to = $path.$image_name;
          move_uploaded_file($_FILES['image']['tmp_name'][$p_img],$move_to);
        }
      }
    }
    $image=implode(',',$up_image);   
  }
  else{
    $image="no.png";
  }
  if((!empty($product_name)) &&(!empty($newprice)) && (!empty($description)) && (!empty($stock)) && (!empty($size)) && (!empty($color)) && (!empty($image))){
    $insert=$db->query("INSERT INTO products(categorys,brands,product_name,product_description,product_size,color,old_price,new_price,in_stock,images) VALUES ($category_id,$brand_id,'$product_name','$description','$size','$color','$oldprice','$newprice','$stock','$image')");
    if($insert){
      $_SESSION['message'] = '<span class="text-success">Product added successfully</span>';
      header('location: product.php'); 
    }
    else{
        $_SESSION['message'] = '<span class="text-danger">Product not addad </span>';
        header('location: product.php'); 
    }
  }
  else{
    $_SESSION['message'] = '<span class="text-danger">Product not addad</span>';
    header('location: product.php');    
  }
}
//suggest
if(isset($_POST['suggest'])){
  $like=$_POST['id'];
  $page=$_POST['page'];
  $suggest=$db->query("INSERT INTO recomended(product_id)VALUES($like)");
  if ($suggest){
    $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-check">Success</i> <span><strong>Recomended  items added successfully</strong></span>
        </div>';
        header('location: product_summary.php?page='.$page); 
  }
  else{
    $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-warning"> Error!</i> <span><strong>Recomended  items not added</strong></span>
        </div>';
        header('location: product_summary.php?page='.$page); 
  }
}
//Add banner
if (isset($_POST['add_banner'])) {
  $category=$_POST['category'];
  if(!empty($_FILES["image"]["name"])){
    $type =pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
    $name =pathinfo($_FILES["image"]["name"],PATHINFO_FILENAME);
    $temp=$_FILES["image"]["tmp_name"];
    $validatefile = array("jpeg","jpg","png");
    if ($_FILES['image']['size'][$p_img] > 5000000) {
      $_SESSION['image'] = "Sorry, your image is too large.";
    }
    if(!in_array($type, $validatefile)) {
      $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
    }
    if(($_FILES["image"]["size"] <= 500000) && (in_array($type, $validatefile)))
    {
      $images=$_FILES["image"]["name"];
      $path = "../images/banners/";
      $target_file = $path.$images;
      if (file_exists($target_file)) {
        $renmae=rand(100,999);
        $move_to = $path.$name.$renmae.'.'.$type;
        $image=$name.$renmae.'.'.$type;
      }
      else{
        $move_to = $path.$images;
        $image=$images;
      }
      move_uploaded_file($temp, $move_to);
    }
  }
  else{
    $image="no.jpeg";
  }
  if((!empty($category)) && (!empty($image))){
    $insert=$db->query("INSERT INTO banner(cat_id,images) VALUES ($category,'$image')");
    if($insert){
      $_SESSION['message'] = '<span class="text-success">Banner added successfully</span>';
      header('location: banner.php');       
    }
    else{
      $_SESSION['message'] = '<span class="text-success">Banner not added </span>';
      header('location: banner.php'); 
    }
  }
  else{
    $_SESSION['message'] = '<span class="text-success">Banner not added </span>';
      header('location: banner.php'); 
  }
}
?>