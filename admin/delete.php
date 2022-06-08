<?php
session_start();
include 'dbconfig/dbconfig.php';
//delete brand
if(isset($_POST['delete_brand'])){
	$db = $database->open();
	$id=$_POST['id'];
	$page=$_POST['page'];
	$delete=$db->query("DELETE  FROM brand WHERE brand_id=$id");
	if ($delete) {
		$_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-check"> Success</i> <span><strong>Brand deleted successfully</strong></span>
	  </div>';
	}
	else{
		$_SESSION['message'] ='<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		<i class=" fa fa-warning"> Error! </i> <span><strong>Brand not deleted</strong></span>
	  </div>' ;
	}
	header('location: brand_summary.php?page='.$page);	
}
//delete category
if(isset($_POST['delete_category'])){
	$db = $database->open();
	function deleteCategory($id ,$page) {
		global $db;
		$noimage="no.jpeg";
		$sub = $db->query("SELECT * FROM category  WHERE parent_id = $id " );
		while($child =$sub->fetch_assoc()) 
		{
			deleteCategory($child["cat_id"],$page);						
		}
		$query_product = $db->query("SELECT * FROM products WHERE categorys=$id");
		if($query_product->num_rows > 0){
		  while($get_product=$query_product->fetch_assoc()){
			$product_image=$get_product['images'];
			$image=explode(",",$product_image);
			$count_product_image=count($image);
			for ($i=0; $i < $count_product_image ; $i++) { 
			  if($image[$i]!==$noimage){
			  unlink("../images/items/".$image[$i]);
			  } 
			} 
		  }
		}
		$category = $db->query("SELECT * FROM category  WHERE cat_id = $id " );
		while($parent =$category->fetch_assoc()) 
		{
			$image=$parent['image'];
			if($image!==$noimage){
				unlink("../images/category/".$image);
			}							
		}
		if ($db->query("DELETE FROM category WHERE cat_id = $id")) {
			$_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Category deleted successfully</strong></span>
		  </div>';
		}
		else{
			$_SESSION['message'] ='<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-warning"> Error! </i> <span><strong>Category not deleted</strong></span>
		  </div>' ;
		}
		header('location: category_summary.php?page='.$page);   
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	deleteCategory($id,$page);	
}
//delete product
if(isset($_POST['delete_product'])){
	$db = $database->open();
	function deleteProduct($id,$page) {
		global $db;
		$noimage="no.png";
		$get_product = $db->query("SELECT * FROM products WHERE product_id=$id");
		$count=mysqli_num_rows($get_product);
		if($count > 0){
		$product=$get_product ->fetch_assoc();
		$product_image=$product['images'];
			$image=explode(",",$product_image);
			$count_product_image=count($image);
			for ($i=0; $i < $count_product_image ; $i++) { 
				if($image[$i]!==$noimage){
					unlink("../images/items/".$image[$i]);
				} 
			}
		}  
		if ($db->query("DELETE FROM products WHERE product_id = $id")) {
			$_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Product deleted successfully</strong></span>
		  </div>';
		}
		else{
			$_SESSION['message'] ='<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-warning"> Error! </i> <span><strong>Product not deleted</strong></span>
		  </div>' ;
		}
		header('location: product_summary.php?page='.$page);    
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	deleteProduct($id,$page);
}
// delete banner
if(isset($_POST['delete_banner'])){
	$db=$database->open();
	$id=$_POST['id'];
	$page=$_POST['page'];
	$noimage="no.jpeg";
	$get_image=$db->query("SELECT *  FROM banner WHERE id= $id");
	$img=$get_image->fetch_assoc();
	$image=$img['images'];
	if($image!==$noimage){
		unlink("../images/banners/".$image);
	}	
	if ($db->query("DELETE FROM banner WHERE id = $id")) {
		$_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-check"> Success</i> <span><strong>Banner deleted successfully</strong></span>
		  </div>';		
	}
	else{
		$_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<i class=" fa fa-warning"> Error!</i> <span><strong>Banner not deleted</strong></span>
		  </div>';
	}
	header('location: banner.php?page='.$page);

}
?>