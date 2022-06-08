<?php
//banner
function indicator(){
    global $db;
    $count=0;
    $output='';    
    $get_banner=$db->query("SELECT * FROM banner");
    if($get_banner->num_rows > 0){
        while($row=$get_banner->fetch_assoc()){
            if ($count==0) {
                $output.='<li data-target="#category" data-slide-to="'.$count.'" class="active"></li>';
            }
            else{
                $output.='<li data-target="#category" data-slide-to="'.$count.'"></li>';
            }
            $count++;
        }
        echo $output;
    } 
}
function crausal_items(){
    global $db;
    $count=0;
    $output=''; 
    $get_banner=$db->query("SELECT * FROM banner");
    if($get_banner->num_rows > 0){
        while($row=$get_banner->fetch_assoc()){
            if ($count==0) {
                $output.='<div class="carousel-item active">';						     
            }
            else{
                $output.='<div class="carousel-item">';
            }
            $output.='<a href="product.php?category='.base64_encode($row['cat_id']).'"><img src="images/banners/'.$row['images'].'" alt="Banner Image" class="image-fluid banner-img"> 
            </div></a>';
            $count++;
        }
        echo $output;

    } 
}
function shob_by(){
    global $db;
    
}
//category
function main_category(){
    global $db;
    $id=0;
    $get_category=$db->query("SELECT * FROM category WHERE parent_id=$id");
    if($get_category->num_rows > 0){
        while($row=$get_category->fetch_assoc()){ 
    ?>
        <div class="card-banner border-bottom">
            <div class="py-3" style="width:80%">
                <h6 class="card-title text-capitalize"><?php echo $row['category_name']; ?></h6>
                <a href="product.php?category=<?php $cat_id=$row['cat_id']; echo base64_encode($cat_id); ?>" class="btn btn-secondary btn-sm"> View all </a>
            </div> 
            <img src="images/category/<?php echo $row['image']; ?>" height="80" class="img-bg image-fluid p-2">
        </div>
    <?php 
        }
    }    
}
// get product by category id
function get_product($id){
    global $db;
    $limit=2;
    $get_subcategory=$db->query("SELECT * FROM category WHERE parent_id=$id");
    while($sub=$get_subcategory->fetch_assoc()){
        get_product($sub['cat_id']);
    }
    $get_product=$db->query("SELECT * FROM products INNER JOIN category ON products.categorys=category.cat_id INNER JOIN brand ON products.brands=brand.brand_id WHERE products.categorys=$id LIMIT $limit");
    if($get_product->num_rows > 0){
        while($items=$get_product->fetch_assoc()){
        $item = $items['product_id']; 
        $item_id = base64_encode($item);
        $category = $items['categorys'];        
        $item_in = base64_encode($category); 
    ?>
    <div class="col-md-3 col-sm-4 col-6 col-lg-2">
        <div class="product-grid">
            <div class="product-image ">
                <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                <?php
                $image=$items['images'];
                $get_image=explode(',',$image);
                $count_image=count($get_image);
                $i=0;                                 
                if ($count_image > 1) {
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                    echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                }
                else{
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                }
                ?> 
                </a>
                <span class="product-new-label">Sale</span>                
                <?php
                $price=$items['new_price'];
                $old=$items['old_price'];
                $new_price=explode(',',$price);
                $old_price=explode(',',$old);
                if ($old_price[$i] > $new_price[$i]) {
                    $inc=$old_price[$i]-$new_price[$i];
                    $increase=$inc/$old_price[$i]*100;
                    echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                }
                ?>
                
            </div>
            <div class="product-content pl-1 pr-1 text-left">
                <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                <div class="price text-left">
                    <?php 
                    echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                    if ($old_price[$i] > $new_price[$i]) {
                        echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                    }
                    ?>					
                </div>
                <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
            </div>
			<div class="social">                   
				<li><a id="<?php echo base64_decode($item_id); ?>" data-tip="Add to Wishlist" class="wish"><i class="fa fa-heart"></i></a></li>                    
			</div>
        </div>
    </div>
    <?php
        }
    }
}
function all_product(){
    global $db;
    $get_product=$db->query("SELECT * FROM products INNER JOIN category ON products.categorys=category.cat_id INNER JOIN brand ON products.brands=brand.brand_id ORDER BY products.product_id DESC");
    if($get_product->num_rows > 0){
        while($items=$get_product->fetch_assoc()){
        $item = $items['product_id']; 
        $item_id = base64_encode($item); 
        $category = $items['categorys'];        
        $item_in = base64_encode($category);
    ?>
    <div class="col-md-3 col-sm-4 col-6 col-lg-2">
        <div class="product-grid">
            <div class="product-image">
                <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                <?php
                $image=$items['images'];
                $get_image=explode(',',$image);
                $count_image=count($get_image);
                $i=0;                                 
                if ($count_image > 1) {
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                    echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                }
                else{
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                }
                ?> 
                </a>
                <span class="product-new-label">Sale</span>                
                <?php
                $price=$items['new_price'];
                $old=$items['old_price'];
                $new_price=explode(',',$price);
                $old_price=explode(',',$old);
                if ($old_price[$i] > $new_price[$i]) {
                    $inc=$old_price[$i]-$new_price[$i];
                    $increase=$inc/$old_price[$i]*100;
                    echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                }
                ?>
                
            </div>
            <div class="product-content pl-1 pr-1 text-left">
                <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                <div class="price text-left">
                    <?php 
                    echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                    if ($old_price[$i] > $new_price[$i]) {
                        echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                    }
                    ?>
                </div>
                <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
            </div>
			<div class="social">                   
				<li><a id="<?php echo base64_decode($item_id); ?>" data-tip="Add to Wishlist" class="wish"><i class="fa fa-heart"></i></a></li>  
			</div>
        </div>
    </div>
    <?php
        }
    }
}
function recomended(){
    global $db;
    $limit=12;    
    $get_product=$db->query("SELECT * FROM recomended INNER JOIN products ON recomended.product_id=products.product_id INNER JOIN brand ON products.brands=brand.brand_id  LIMIT $limit");
    if($get_product->num_rows > 0){
        ?>
        <section class="padding-bottom mt-2 mt-sm-2 mt-md-2 mt-lg-3 mt-xl-4">
			<header class="section-heading heading-line">
				<h4 class="title-section text-uppercase btn text-muted btn-primary">you may like</h4>
				<h4 class="title-section text-uppercase btn text-muted btn-primary float-right"><a href="recomended=recomended ">more</a></h4>
			</header>
			<div class="card card-home-category rounded-0">
				<div class="no-gutters">
					<div class="col-md-12 ">
						<ul class="row no-gutters p-0 mb-0">
                        <?php
                        while($items=$get_product->fetch_assoc()){
                        $item = $items['product_id']; 
                        $item_id = base64_encode($item);
                        $category = $items['categorys'];        
                        $item_in = base64_encode($category);
                        ?>
                            <div class="col-md-3 col-sm-4 col-6 col-lg-2">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                                        <?php
                                        $image=$items['images'];
                                        $get_image=explode(',',$image);
                                        $count_image=count($get_image);
                                        $i=0;                                 
                                        if ($count_image > 1) {
                                            echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                                            echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                                        }
                                        else{
                                            echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                                        }
                                        ?> 
                                        </a>                                       
                                        <span class="product-new-label">Sale</span>                                        
                                        <?php
                                        $price=$items['new_price'];
                                        $old=$items['old_price'];
                                        $new_price=explode(',',$price);
                                        $old_price=explode(',',$old);
                                        if ($old_price[$i] > $new_price[$i]) {
                                            $inc=$old_price[$i]-$new_price[$i];
                                            $increase=$inc/$old_price[$i]*100;
                                            echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                                        }
                                        ?>
                                        
                                    </div>
                                    <div class="product-content pl-1 pr-1 text-left">
                                        <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                                        <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                                        <div class="price  text-left">
                                            <?php 
                                            echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                                            if ($old_price[$i] > $new_price[$i]) {
                                                echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                                            }
                                            ?>
                                        </div>
                                        <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
										
                                    </div>
									<div class="social">                   
										<li><a id="<?php echo base64_decode($item_id); ?>" data-tip="Add to Wishlist" class="wish"><i class="fa fa-heart"></i></a></li>  
									</div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            </ul>
                        </div> 
                    </div> 
                </div> 
            </section>
        <?php
    }
}
//Shop by
function shopby($id){
    global $db;
    $get_product=$db->query("SELECT * FROM products INNER JOIN category ON products.categorys=category.cat_id INNER JOIN brand ON products.brands=brand.brand_id WHERE products.categorys=$id ORDER BY products.product_id DESC");
    if($get_product->num_rows > 0){
        while($items=$get_product->fetch_assoc()){
        $item = $items['product_id']; 
        $item_id = base64_encode($item);
        $category = $items['categorys'];        
        $item_in = base64_encode($category); 
    ?>
    <div class="col-md-3 col-sm-4 col-6 col-lg-2">
        <div class="product-grid">
            <div class="product-image ">
                <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                <?php
                $image=$items['images'];
                $get_image=explode(',',$image);
                $count_image=count($get_image);
                $i=0;                                 
                if ($count_image > 1) {
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                    echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                }
                else{
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                }
                ?> 
                </a>
                <span class="product-new-label">Sale</span>                
                <?php
                $price=$items['new_price'];
                $old=$items['old_price'];
                $new_price=explode(',',$price);
                $old_price=explode(',',$old);
                if ($old_price[$i] > $new_price[$i]) {
                    $inc=$old_price[$i]-$new_price[$i];
                    $increase=$inc/$old_price[$i]*100;
                    echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                }
                ?>
                
            </div>
            <div class="product-content pl-1 pr-1  text-left">
                <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                <div class="price  text-left">
                    <?php 
                    echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                    if ($old_price[$i] > $new_price[$i]) {
                        echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                    }
                    ?>
                </div>
                <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
            </div>
			<div class="social">                   
				<li><a id="<?php echo base64_decode($item_id); ?>" data-tip="Add to Wishlist" class="wish"><i class="fa fa-heart"></i></a></li>  
			</div>
        </div>
    </div>
    <?php
        }
    }
    else{
       echo '<div class="col-12 text-center f-100"><i class="fas fa-box-open"></i> No items found</div>'; 
    }
}
//similar items
function similar_product($id){
    global $db;
    $limit = 12;
    $get_product=$db->query("SELECT * FROM products INNER JOIN category ON products.categorys=category.cat_id INNER JOIN brand ON products.brands=brand.brand_id WHERE products.categorys=$id ORDER BY products.product_id  DESC LIMIT $limit");
    if($get_product->num_rows > 0){
        while($items=$get_product->fetch_assoc()){
        $item = $items['product_id']; 
        $item_id = base64_encode($item);
        $category = $items['categorys'];        
        $item_in = base64_encode($category); 
    ?>
    <div class="col-md-3 col-sm-4 col-6 col-lg-2">
        <div class="product-grid">
            <div class="product-image ">
                <a href="product_details.php?items=<?php echo $item_id; ?>&items_in=<?php echo $item_in; ?>">
                <?php
                $image=$items['images'];
                $get_image=explode(',',$image);
                $count_image=count($get_image);
                $i=0;                                 
                if ($count_image > 1) {
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                    echo '<img class="pic-2" src="images/items/'.$get_image[$i+1].'">';
                }
                else{
                    echo '<img class="pic-1" src="images/items/'.$get_image[$i].'">';
                }
                ?> 
                </a>
                <span class="product-new-label">Sale</span>                
                <?php
                $price=$items['new_price'];
                $old=$items['old_price'];
                $new_price=explode(',',$price);
                $old_price=explode(',',$old);
                if ($old_price[$i] > $new_price[$i]) {
                    $inc=$old_price[$i]-$new_price[$i];
                    $increase=$inc/$old_price[$i]*100;
                    echo '<span class="product-discount-label">'.ceil($increase).' % off</span>';
                }
                ?>
                
            </div>
            <div class="product-content pl-1 pr-1  text-left">
                <h3 class="title text-dark"><a ><?php echo $items['product_name']; ?></a></h3>
                <h3 class="brand text-dark"><a ><?php echo $items['brand_name']; ?></a></h3>
                <div class="price  text-left">
                    <?php 
                    echo "<i class='fa fa-rupee'></i> ".$new_price[$i];
                    if ($old_price[$i] > $new_price[$i]) {
                        echo " <span><i class='fa fa-rupee'></i>" .$old_price[$i]."</span>";
                    }
                    ?>
                </div>
                <a class="add-to-cart text-dark" href="">Size <i class='fa fa-arrow-right'></i> <?php echo $items['product_size']; ?></a>
            </div>
			<div class="social">                   
				<li><a id="<?php echo base64_decode($item_id); ?>" data-tip="Add to Wishlist" class="wish"><i class="fa fa-heart"></i></a></li>  
			</div>
        </div>
    </div>
    <?php
        }
    }
    else{
       echo '<div class="col-12 text-center f-100"><i class="fas fa-box-open"></i> No items found</div>'; 
    }
}
?>