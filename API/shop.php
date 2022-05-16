<?php
require_once 'require.php';

$limit = 9;
$page = 1;
if ($_POST['page']>1){
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
}
else{
    $start = 0;
}

$query = "SELECT product.product_id, product.product_name, product.product_price, product.product_discount, product.product_thumb, product.product_view, review.review_rating, cate_product.cate_id FROM product
            LEFT  JOIN  review ON product.product_id = review.product_id
            INNER JOIN cate_product ON cate_product.product_id = product.product_id
            WHERE product.product_status = 1
            ";
if ($_POST['query'] != ''){
    $key = handleField($_POST['query']);
    $query .= ' AND product.product_name LIKE "%'.str_replace(' ','%', $key).'%"
    ';
}
if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])){
    $query .= " 
    AND product.product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'";
}
if(isset($_POST["cate"]))
 {
  $cate_filter = implode("','", $_POST["cate"]);
  $query .= "
   AND cate_product.cate_id IN ('".$cate_filter."')
  ";
 }

$query .= ' GROUP BY product.product_id, cate_product.product_id ';

if($_POST['sort'] == 1 ){
    $query .= " ORDER BY product.product_id DESC";
}elseif ($_POST['sort'] == 2){
   $query .= " ORDER BY product.product_id ASC";
}elseif ($_POST['sort'] == 3){
   $query .= " ORDER BY product.product_view DESC";
}elseif ($_POST['sort'] == 4){
   $query .= " ORDER BY product.product_price ASC";
}elseif ($_POST['sort'] == 5){
   $query .= " ORDER BY product.product_price DESC";
}

$filter_query = $query . ' LIMIT '.$start.', '.$limit.'';

$total_data = DB::rowCount($query);
$currentData = DB::rowCount($filter_query);
$result = DB::fetchAll($filter_query);
$output = '
                <!--toolbar sort by-->
                <div class="toolbar">
                    <p style="color: #858585">Showing '.$currentData.' products</p>
                    <select name="" class="sort-by">
                        <option value="1">Default</option>
                        <option value="2">Oldest</option>
                        <option value="3">View</option>
                        <option value="4">Price low to high</option>
                        <option value="5">Price high to low</option>
                    </select>
                </div>
                <!--toolbar sort by end-->
';

$output .=' <!--list product-->
        <div class="list-product">';

if ($total_data > 0){
    foreach ($result as $value){
        $output .= '
                    <div class="product-item">
                        <a href="'.ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id'].'/">
                            <div class="product-item__image">
                                <img src="'.ROOT_URL.'/assets/uploads/product/'. $value['product_thumb'] .'">
                                <div class="product-item__btn">
                                    <button data-toggle="tooltip" title="Quickview" data-placement="top" data-type-btn="quickview" data-modal-delay="1000" data-product-id="'.$value['product_id'].'" data-modal="modal" data-target="#quickview"><i class="fas fa-search-plus"></i></button>
                                    <button data-toggle="tooltip" title="Add to Cart" data-placement="top" data-type-btn="add-to-cart" data-product-id="'.$value['product_id'].'"><i class="fas fa-cart-plus"></i></button>
                                    <button data-toggle="tooltip" class="'.(issetWishlist($value['product_id']) ? "added" : "").'" data-type-btn="add-to-wishlist" data-product-id="'.$value['product_id'].'" title="Add to Wishlist" data-placement="top">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-heart added"></i>
                                    </button>
                                </div>';
        if($value['product_discount'] > 0) $output .= '<div class="product-item__badge">-'.$value['product_discount'].'</div>';
        $output .= '</div>
                        </a>
                        <div class="product-item__info">
                            <a href="product.php?id='.$value['product_id'].'" title="Sandwich">
                                <div class="product-item__info--name">'. $value['product_name'].'</div>
                            </a>
                            <div class="product-item__info--price">'.(($value['product_discount'] > 0) ? product_price($value['product_price']-(($value['product_discount']*$value['product_price'])/100))." <del>".product_price($value['product_price'])."</del>" : product_price($value['product_price'])).'</div>
                            <div class="product-item__info--rating">
                                <div class="rateit" data-rateit-mode="font" data-rateit-value="'. $value['review_rating'] .'" data-rateit-readonly="true"></div>
                            </div>
                        </div>
                    </div>
               
        ';
    }
    $output .= ' </div>
<!--list product end-->';

$output .= '
 <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';


if ($total_links > 3){
    if ($page <4){
        for ($count = 1; $count <=4; $count++){
            $page_array[] = $count;
        }
    }else{
        $end_limit = $total_links - 4;

        if ($page > $end_limit){

            for ($count = $end_limit + 1; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }else{
            for ($count = $page - 1; $count <= $page; $count++){
                $page_array[] = $count;
            }
        }
    }
}else{
    for ($count = 1; $count <= $total_links;$count++){
        $page_array[] = $count;

    }
}

for ($count = 0; $count < count($page_array); $count++){
    if ($page == $page_array[$count]){
        $page_link .= '
            <li style="user-select:none;pointer-events:none;"><a class="page-link active" href="#">'. $page_array[$count] .'</a></li>
';
        $previous_id = $page_array[$count] - 1;

        if ($previous_id > 0){
            $previous_link .= '
            <li><a class="page-link" href="javascript:void(0)" data-page_number = "'. $previous_id .'"><i class="fas fa-angle-left"></i></a></li>
            ';
        }else{
            $previous_link .= '
            <li class="disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
            ';
        }

        $next_id = $page_array[$count] + 1;

        if ($next_id > $total_links){
            $next_link .= '
             <li class="disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
            ';
        }else{
            $next_link .= '
             <li><a class="page-link" href="#" data-page_number = "'. $next_id.'"><i class="fas fa-angle-right"></i></a></li>
            ';
        }
    }else{
        $page_link .= '
            <li><a class="page-link" href="javascript:void(0)" data-page_number = "'. $page_array[$count].'">'.$page_array[$count].'</a></li>
            ';
    }
}

$output .= $previous_link . $page_link . $next_link;
} else{
    $output = '<div class="not-found-data">
                    <img src="'.ROOT_URL.'/assets/img/cake-cry.png" style="width: 50%;object-fit:cover;display:block;margin: 0 auto">
                    <p style="text-align:center;font-weight:700">No Products Found</p>
                </div>
                    ';
}

echo $output;

?>