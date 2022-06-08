<?php
session_start();
include 'dbconfig/dbconfig.php';
//Edit brand
if(isset($_POST['edit_brand'])){
    $db = $database->open();
    $id=$_POST['edit'];
    $page=$_POST['page'];
    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['brand'])) {
        $_SESSION['brand_name'] = ' Brand name error ';
        header('location: brand.php?edit='.$id.'&page='.$page);
    }
    else{
        $brand_name=$_POST['brand'];
        if(!empty($brand_name)){        
        $update=$db->query("UPDATE  brand SET brand_name='$brand_name' WHERE brand_id=$id");
            if($update){
                $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <i class=" fa fa-check">Success</i> <span><strong>Brand updated successfully</strong></span>
                </div>';
                header('location: brand_summary.php?page='.$page);
            }
            else{
              $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <i class=" fa fa-warning"> Error!</i> <span><strong>Brand not updated </strong></span>
                </div>';
                header('location: brand_summary.php?page='.$page);
            }
        }
        else{
          $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <i class=" fa fa-warning"> Error!</i> <span><strong>Brand not updated </strong></span>
          </div>';
          header('location: brand_summary.php?page='.$page);
        }
    }
}
//Category update
if (isset($_POST['edit_category'])) {
  $db = $database->open();
    $ids=$_POST['edit'];
    $page=$_POST['page'];
    $p_id=$_POST['p_id'];
    if(!empty($_POST['category'])){
      $parent_category=$_POST['category'];
    }
    else{
      $parent_category =0;
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
      $images=$_FILES["image"]["name"];
      $path = "../images/category/";
      $target_file = $path.$images;
      if ($_FILES["image"]["size"] > 500000) {
        $_SESSION['image'] = "Sorry, your image is too large.";
      }
      if(!in_array($type, $validatefile)) {
        $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
      }
      if(($_FILES["image"]["size"] < 500000) && (in_array($type, $validatefile)))
      {
        $default=$_POST['default_image'];
        $no_image="no.jpeg";
        if($default!==$no_image){
          unlink("../images/category/".$default);
        }
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
      $image=$_POST['default_image'];
    }
    if((!empty($category_name)) && (!empty($image))){
      $update=$db->query("UPDATE category SET category_name='$category_name', parent_id='$parent_category' , image='$image' WHERE cat_id=$ids");
      if($update){
        $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-check">Success</i> <span><strong>Category updated successfully</strong></span>
        </div>';
        header('location: category_summary.php?page='.$page); 
      }
      else{
        $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-warning"> Error!</i> <span><strong>Category not updated </strong></span>
        </div>';
        header('location: category_summary.php?page='.$page); 
      }
    }
    else{
      $_SESSION['message'] = '<span class="text-danger">Category not update</span>';
        header('location: category.php?edit='.$ids.'&page='.$page.'&p_id='.$p_id); 
    }
  }
  if (isset($_POST['edit_product'])) {
    $db = $database->open();
    $category_id=$_POST['category'];
    $ids=$_POST['edit'];
    $page=$_POST['page'];
    $p_id=$_POST['p_id'];
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
    $oldprice=implode(',',$_POST["oldprice"]);
    
    if(!empty(array_filter($_FILES['image']['name']))){
      $validatefile = array("jpeg","jpg","png");
      $up_image = array();
      foreach($_FILES['image']['name'] as $p_img => $image_name){
        $type = pathinfo($image_name, PATHINFO_EXTENSION);
        $name = pathinfo($image_name, PATHINFO_FILENAME);
        if ($_FILES["image"]["size"] > 500000) {
          $_SESSION['image'] = "Sorry, your image is too large.";
        }
        if(!in_array($type, $validatefile)) {
            $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
        }
        if(($_FILES['image']['size'][$p_img] <= 5000000) && in_array($type, $validatefile)){
          $path = "../images/items/";
          $file_exits = $path.$image_name;
          $default=$_POST['default_image'];
          $explode_image=explode(',',$default);
          $count_img=count($explode_image);
          $no_image="no.jpeg";
          for ($i=0; $i < $count_img; $i++) {          
            if($explode_image[$i]!==$no_image){
              unlink($path.$explode_image[$i]);
            }
          }        
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
      $image=$_POST['default_image'];
    }
    if((!empty($product_name)) &&(!empty($newprice)) && (!empty($description)) && (!empty($stock)) && (!empty($size)) && (!empty($color)) && (!empty($image))){
      $update=$db->query("UPDATE products SET categorys='$category_id',brands='$brand_id',product_name='$product_name',product_description='$description',product_size='$size',color='$color',old_price='$oldprice',new_price='$newprice',in_stock='$stock',images='$image' WHERE product_id=$ids");
      if($update){
        $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-check">Success</i> <span><strong>Product updated successfully</strong></span>
        </div>';
        header('location: product_summary.php?page='.$page); 
      }
      else{
        $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <i class=" fa fa-warning"> Error!</i> <span><strong>Product not updated </strong></span>
        </div>';
        header('location: product_summary.php?page='.$page); 
      }
    }
    else{ 
      $_SESSION['message'] = '<span class="text-danger">Product not update</span>';
        header('location: product.php?edit='.$ids.'&page='.$page.'&p_id='.$p_id.'&brand='.$brand_id); 
    }
  }
  if (isset($_POST['edit_banner'])) {
    $db=$database->open();
    $ids=$_POST['edit'];
    $page=$_POST['page'];
    $category=$_POST['category'];
    if(!empty($_FILES["image"]["name"])){
      $type =pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
      $name =pathinfo($_FILES["image"]["name"],PATHINFO_FILENAME);
      $temp=$_FILES["image"]["tmp_name"];
      $validatefile = array("jpeg","jpg","png");
      $images=$_FILES["image"]["name"];
      $path = "../images/banners/";
      $target_file = $path.$images;
      if ($_FILES['image']['size'][$p_img] > 5000000) {
        $_SESSION['image'] = "Sorry, your image is too large.";
      }
      if(!in_array($type, $validatefile)) {
        $_SESSION['image'] = "Only JPG, JPEG and PNG accept";
      }
      if(($_FILES["image"]["size"] <= 500000) && (in_array($type, $validatefile)))
      {
        $default=$_POST['default_image'];
        $no_image="no.jpeg";
        if($default!==$no_image){
          unlink("../images/banners/".$default);
        }
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
      $image=$_POST['default_image'];
    }
    if((!empty($category)) && (!empty($image))){
        $update=$db->query("UPDATE  banner SET cat_id='$category',images='$image' WHERE id=$ids");
        if($update){
          $_SESSION['message'] = '<span class="text-success">Banner updated successfully</span>';
          header('location: banner.php?page='.$page);
        }
        else{
          $_SESSION['message'] = '<span class="text-success">Banner not updated</span>';
          header('location: banner.php?page='.$page);
        }
      }
      else{
        $_SESSION['message'] = '<span class="text-success">Banner not updateds</span>';
        header('location: banner.php?page='.$page);
    }
  }

?> 