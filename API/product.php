<?php
require_once 'require.php';
$error = [];
$status = 'error';
if(isset($_POST['get']) && $_POST['get'] == 'list-product'){
    $sql = "SELECT product_id, product_name, product_price, product_discount, product_thumb, product_status, product_view FROM product";
    $list = DB::fetchAll($sql);
    echo json_encode($list);
}
if(isset($_POST['action']) && $_POST['action'] == 'add-product'){
    $name           = handleField($_POST['name']);
    $price          = $_POST['price'];
    $discount       = $_POST['discount'];
    $description    = preg_replace("#(script>|onclick|javascript:)#i","", $_POST['description']);
    $thumbnail      = $_FILES['thumbnail'];
    $album          = $_FILES['album'];
    $categories     = $_POST['categories'];
    if(!checkLength($name, 3, 10000)){
        $error['name'] = 'Minimum length of product name is 3';
    }
    if($thumbnail['error'] > 0){
        $error['thumbnail'] = 'Image file has error';
    } else if(!checkExtension($thumbnail['name'])){
        $error['thumbnail'] = 'Incorrect image format';
    }
    if(count($error) == 0){
        $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
        $thumbName = 'thumb-'.randomStr().'.'.$fileExtension;
        $sql = "INSERT INTO product(product_name, product_price, product_discount, product_thumb, product_album, product_description, product_status, product_view) VALUES('$name', $price, $discount, '$thumbName', '[]', '$description', 1, 0)";
        try{
            DB::execute($sql);
        } catch(PDOException $e){
            $error[] = $e->getMessage();
        }
        $currentProduct = DB::lastInsertID();
        foreach($categories as $value){
            $sql = "INSERT INTO cate_product VALUES ($currentProduct, $value)";
            try{
                DB::execute($sql);
            } catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
        $albumArr = [];
        if($album['size'][0] > 0){
            foreach($album['name'] as $key => $value){
                $fileExtension = pathinfo($value, PATHINFO_EXTENSION);
                $fileAlbum = 'album-'.$currentProduct.'-'.randomStr().'.'.$fileExtension;
                $albumArr[] = $fileAlbum;
            }
            $sql = "UPDATE product SET product_album = '".json_encode($albumArr)."' WHERE product_id = $currentProduct";
            try{
                DB::execute($sql);
            }catch(PDOException $e){
                $e->getMessage();
            }
        }
        if(count($error) == 0){
            move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/product/' . $thumbName);
            foreach($albumArr as $key=>$value){
                move_uploaded_file($album['tmp_name'][$key], '../assets/uploads/product/' . $value);
            }
            $status = 'success';
        }
    }
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'product'){
    $id = (int)$_POST['id'];
    $product = DB::fetch("SELECT * FROM product WHERE product_id = $id");
    $categories = DB::fetchAll("SELECT cate_id FROM cate_product WHERE product_id = $id");
    $dataCat = [];
    foreach($categories as $cat){
        $dataCat[] = $cat['cate_id'];
    }
    $data = [
        'id'            => $product['product_id'],
        'name'          => $product['product_name'],
        'price'         => $product['product_price'],
        'discount'      => $product['product_discount'],
        'thumb'         => $product['product_thumb'],
        'album'         => json_decode($product['product_album']),
        'description'   => $product['product_description'],
        'status'        => $product['product_status'],
        'categories'    => $dataCat
    ];
    echo json_encode($data);
}
// if(isset($_POST['get']) && $_POST['get'] == 'product-quickview'){
//     $id = (int)$_POST['id'];
//     $product = DB::fetch("SELECT product.*, AVG(review_rating) as rating FROM product,review WHERE product.product_id = $id AND product.product_id = review.product_id");
//     $categories = DB::fetchAll("SELECT category.cate_id,category.cate_name FROM cate_product,category WHERE cate_product.product_id = $id AND category.cate_id = cate_product.cate_id");
//     $dataCat = [];
//     foreach($categories as $cat){
//         $dataCat[] = [
//             'id'    => $cat['cate_id'],
//             'name'  => $cat['cate_name']
//         ];
//     }
//     $data = [
//         'id'            => $product['product_id'],
//         'name'          => $product['product_name'],
//         'price'         => product_price($product['product_price']),
//         'discount'      => $product['product_discount'],
//         'thumb'         => $product['product_thumb'],
//         'album'         => json_decode($product['product_album']),
//         'description'   => $product['product_description'],
//         'status'        => $product['product_status'],
//         'rating'        => $product['rating'],
//         'categories'    => $dataCat
//     ];
//     echo json_encode($data);
// }
if(isset($_POST['get']) && $_POST['get'] == 'product-quickview'){
    $xhtml = '';
    $id = (int)$_POST['id'];
    $product = DB::fetch("SELECT product.*, AVG(review_rating) as rating FROM product,review WHERE product.product_id = $id AND product.product_id = review.product_id");
    $categories = DB::fetchAll("SELECT category.cate_id,category.cate_name FROM cate_product,category WHERE cate_product.product_id = $id AND category.cate_id = cate_product.cate_id");
    $album = json_decode($product['product_album']);
    $xhtml .= '<div class="product-info">
                    <div class="product-info__image">
                        <div class="product-info__image--thumb">
                        <img src="'.ROOT_URL.'/assets/uploads/product/'.$product['product_thumb'].'">';
    foreach($album as $img){
        $xhtml .= '<img src="'.ROOT_URL.'/assets/uploads/product/'.$img.'">';
    }
    $xhtml .= '</div>
                    </div>
                    <div class="product-info__detail">
                        <div class="product-info__detail--name">'.$product['product_name'].'</div>
                        <div class="product-info__detail--price">';
    if($product['product_discount'] > 0){
        $xhtml .= product_price($product['product_price']-(($product['product_discount']*$product['product_price'])/100)).' <del>'.product_price($product['product_price']).'</del>';
    } else {
        $xhtml .= product_price($product['product_price']);
    }
    $xhtml.= '</div>
                    <div class="product-info__detail--rating">
                        <div class="rating-avg rateit" data-rateit-value="'.$product['rating'].'" data-rateit-readonly="true" data-rateit-mode="font" style="font-size:40px" data-rateit-resetable="false" data-rateit-ispreset="true"></div>
                    </div>
                        <div class="product-info__detail--short-description">'.strip_tags($product['product_description']).'</div>
                        <div class="product-info__detail--btn">
                            <div class="quantity__btn">
                                <button class="quantity__button sub"><i class="fas fa-minus"></i></button>
                                <input type="number" name="quantity" step="1" value="1" class="input-quantity" min="1">
                                <button class="quantity__button add"><i class="fas fa-plus"></i></button>
                            </div>
                            <button class="add-to-cart" data-product-id="'.$product['product_id'].'"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            <button class="add-to-wishlist '.(issetWishlist($product['product_id']) ? 'added' : '').'" data-type-btn="add-to-wishlist" data-product-id="'.$product['product_id'].'" data-toggle="tooltip" title="Add to Wishlist" data-placement="top">
                                <i class="fas fa-heart added"></i>
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="product-info__detail--categories">Categories: ';
                        for($i = 0;$i < count($categories);$i++){
                            if($i == count($categories)-1){
                                $xhtml .= '<a href="'.ROOT_URL.'/shop/?category='.$categories[$i]["cate_id"].'">'.$categories[$i]["cate_name"].'</a>';
                            } else {
                                $xhtml .= '<a href="'.ROOT_URL.'/shop/?category='.$categories[$i]["cate_id"].'">'.$categories[$i]["cate_name"].'</a>, ';
                            }
                        }
    $xhtml .= '</div>
                </div>';
    echo $xhtml;
}
if(isset($_POST['get']) && $_POST['get'] == 'album'){
    $id = (int)$_POST['id'];
    $product = DB::fetch("SELECT * FROM product WHERE product_id = $id");
    $data = [
        'album'         => json_decode($product['product_album']),
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'remove-album'){
    $pos = (int)$_POST['pos'];
    $productID = (int)$_POST['id'];
    $product = DB::fetch("SELECT * FROM product WHERE product_id = $productID");
    $album = json_decode($product['product_album']);
    //unlink('../assets/uploads/product/'. $album[$pos]);
    unset($album[$pos]);
    $album = json_encode(array_values($album));
    try{
        DB::execute("UPDATE product SET product_album = '$album' WHERE product_id = $productID");
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error)==0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'update-product'){
    $id             = (int)$_POST['id'];
    $name           = handleField($_POST['name']);
    $price          = $_POST['price'];
    $discount       = $_POST['discount'];
    $productStatus  = (int)$_POST['status'];
    $description    = preg_replace("#(script>|onclick|javascript:)#i","", $_POST['description']);
    $thumbnail      = $_FILES['thumbnail'];
    $album          = $_FILES['album'];
    $categories     = $_POST['categories'];
    if(!checkLength($name, 3, 10000)){
        $error['name'] = 'Minimum length of product name is 3';
    }
    if(count($error) == 0){
        $sql = "UPDATE product SET product_name = '$name', product_price = $price, product_discount = $discount, product_description = '$description', product_status = $productStatus WHERE product_id = $id";
        try{
            DB::execute($sql);
        } catch(PDOException $e){
            $error[] = $e->getMessage();
        }
        try{
            DB::execute("DELETE FROM cate_product WHERE product_id = $id");
        } catch(PDOException $e){
            $error['delete'] = $e->getMessage();
        }
        foreach($categories as $value){
            try{
                DB::execute("INSERT INTO cate_product VALUES ($id, $value)");
            } catch(PDOException $e){
                $error['cat'] = $e->getMessage();
            }
        }
        if($thumbnail['size'] > 0){
            if($thumbnail['error'] > 0){
                $error['thumbnail'] = 'Image file has error';
            } else if(!checkExtension($thumbnail['name'])){
                $error['thumbnail'] = 'Incorrect image format';
            } else {
                $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
                $thumbName = 'thumb-'.randomStr().'.'.$fileExtension;
                try{
                    DB::execute("UPDATE product SET product_thumb = '$thumbName' WHERE product_id = $id");
                }catch(PDOException $e){
                    $error[] = $e->getMessage();
                }
                if(count($error) == 0){
                    move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/product/' . $thumbName);
                }
            }
        }
        $currentAlbum = json_decode(DB::fetch("SELECT product_album FROM product WHERE product_id = $id")['product_album']);
        $albumArr = [];
        if($album['size'][0] > 0){
            foreach($album['name'] as $key => $value){
                $fileExtension = pathinfo($value, PATHINFO_EXTENSION);
                $fileAlbum = 'album-'.$id.'-'.randomStr().'.'.$fileExtension;
                $albumArr[] = $fileAlbum;
            }
            $sql = "UPDATE product SET product_album = '".json_encode(array_values(array_merge($albumArr, $currentAlbum)))."' WHERE product_id = $id";
            try{
                DB::execute($sql);
            }catch(PDOException $e){
                $e->getMessage();
            }
            if(count($error) == 0){
                foreach($albumArr as $key=>$value){
                    move_uploaded_file($album['tmp_name'][$key], '../assets/uploads/product/' . $value);
                }
            }
        }
        if(count($error) == 0){
            $status = 'success';
        }
    }
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['product']) && isset($_POST['action']) && $_POST['action'] == 'delete-product'){
    $id = (int)$_POST['product'];
    try{
        $sql      = "DELETE FROM product WHERE product_id = $id";
        DB::execute($sql);
    } catch (PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['products']) && isset($_POST['action']) && $_POST['action'] == 'disable-all'){
    $category = $_POST['products'];
    $listCat = array_map(function($value){
        return (int)$value;
    }, $category);
    foreach($listCat as $value){
        try{
            $sql      = "UPDATE product SET product_status = 0 WHERE product_id = $value";
            DB::execute($sql);
        } catch (PDOException $e){
            $error[] = $e->getMessage();
        }
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['products']) && isset($_POST['action']) && $_POST['action'] == 'enable-all'){
    $category = $_POST['products'];
    $listCat = array_map(function($value){
        return (int)$value;
    }, $category);
    foreach($listCat as $value){
        try{
            $sql      = "UPDATE product SET product_status = 1 WHERE product_id = $value";
            DB::execute($sql);
        } catch (PDOException $e){
            $error[] = $e->getMessage();
        }
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'live-search'){
    $xhtml = '';
    $key = handleField($_POST['key']);
    $sql = "SELECT product.*, AVG(review_rating) as rating FROM product
    LEFT JOIN review ON review.product_id = product.product_id WHERE product.product_status = 1 AND product.product_name LIKE '%$key%' GROUP BY product.product_id";
    $listResult = DB::fetchAll($sql);
    $data = [];
    foreach($listResult as $product){
        $data[] = [
            'id'    => $product['product_id'],
            'thumb' => $product['product_thumb'],
            'name'  => $product['product_name'],
            'rating'=> $product['rating'],
            'price' => ($product['product_discount'] > 0) ? $product['product_price']-($product['product_price']*$product['product_discount']/100) : $product['product_price']
        ];
    }
    foreach($data as $value){
        $xhtml .= '<a href="'.ROOT_URL.'/product/'.slug($value['name']).'-'.$value['id'].'">
                        <div class="search-result__item">
                            <div class="search-result__item--image">
                                <img src="'.ROOT_URL.'/assets/uploads/product/'.$value['thumb'].'">
                            </div>
                            <div class="search-result__item--info">
                                <div class="search-result__name">'.$value['name'].'</div>
                                <div class="rateit" data-rateit-value="'.$value['rating'].'" data-rateit-resetable="false" data-rateit-readonly="true" data-rateit-ispreset="true"></div>
                                <div class="search-result__price">'.product_price($value['price']).'</div>
                            </div>
                        </div>
                    </a>
                    ';
    }
    echo $xhtml;
}
if(isset($_POST['get']) && $_POST['get'] == 'statistic'){
    $strDate = handleField($_POST['date_range']);
    $strDate = explode("-", $strDate);
    $before = date_parse_from_format("d/m/Y", $strDate[0]);
    $after  = date_parse_from_format("d/m/Y", $strDate[1]);
    $dateBefore = date("Y-m-d H:i:s", mktime(0, 0, 0, $before['month'], $before['day'], $before['year']));
    $dateAfter = date("Y-m-d H:i:s", mktime(23, 59, 59, $after['month'], $after['day'], $after['year']));
    $orderRange = DB::rowCount("SELECT * FROM orders WHERE order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // so don hang
    $orderCancel = DB::rowCount("SELECT * FROM orders WHERE order_status = 0 AND order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // so don hang da huy
    $orderPending = DB::rowCount("SELECT * FROM orders WHERE order_status = 1 AND order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // so don hang da dat
    $orderShipping = DB::rowCount("SELECT * FROM orders WHERE order_status = 2 AND order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // so don hang dang giao
    $orderSuccess = DB::rowCount("SELECT * FROM orders WHERE order_status = 3 AND order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // so don hang thanh cong
    $productRange = DB::rowCount("SELECT * FROM order_detail, orders WHERE orders.order_status = 3 AND order_detail.order_id = orders.order_id AND orders.order_date BETWEEN '$dateBefore' AND '$dateAfter'"); // loai san pham
    $sumQtyProduct = DB::fetch("SELECT SUM(order_detail.product_price*order_detail.product_quantity) as total_price,SUM(order_detail.product_quantity) as qty FROM order_detail, orders WHERE orders.order_status = 3 AND order_detail.order_id = orders.order_id AND orders.order_date BETWEEN '$dateBefore' AND '$dateAfter'");
    $countProduct = DB::fetchAll("SELECT order_detail.product_id, product.product_name, COUNT(order_detail.product_id) as qty FROM order_detail, product, orders WHERE product.product_id = order_detail.product_id AND orders.order_id = order_detail.order_id AND orders.order_date BETWEEN '$dateBefore' AND '$dateAfter' GROUP BY order_detail.product_id ORDER BY qty DESC LIMIT 0,5");
    $sumProduct = DB::fetchAll("SELECT order_detail.product_id, product.product_name, SUM(order_detail.product_quantity) as qty FROM order_detail, product, orders WHERE product.product_id = order_detail.product_id AND orders.order_id = order_detail.order_id AND orders.order_date BETWEEN '$dateBefore' AND '$dateAfter' GROUP BY order_detail.product_id ORDER BY qty DESC LIMIT 0,5");
    $data = [
        'order_qty'     => $orderRange,
        'order_cancel'  => $orderCancel,
        'order_pending' => $orderPending,
        'order_ship'    => $orderShipping,
        'order_success' => $orderSuccess,
        'product_qty'   => $productRange ?? 0,
        'sum_product'   => $sumQtyProduct['qty'] ?? 0,
        'revenue'       => product_price($sumQtyProduct['total_price']),
        'count_product' => $countProduct,
        'sum_products'   => $sumProduct
    ];
    echo json_encode($data);
}
?>