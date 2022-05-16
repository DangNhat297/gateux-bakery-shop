<?php
require_once 'require.php';
$status = 'error';
$error = array();
if(isset($_POST['get']) && $_POST['get'] == 'wishlist'){
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        $wishlist = DB::fetchAll("SELECT * FROM wishlist WHERE user_id = $userID");
        $data = [];
        foreach($wishlist as $item){
            $product = DB::fetch("SELECT * FROM product WHERE product_id = ". $item['product_id'] . " AND product_status = 1");
            $data[] = [
                'id'    => $product['product_id'],
                'thumb' => $product['product_thumb'],
                'name'  => $product['product_name'],
                'price' => product_price($product['product_price'])
            ];
        }
    } else {
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        $data = [];
        foreach($wishlist as $value){
            $product = DB::fetch("SELECT * FROM product WHERE product_id = $value AND product_status = 1");
            $data[] = [
                'id'    => $product['product_id'],
                'thumb' => $product['product_thumb'],
                'name'  => $product['product_name'],
                'price' => product_price($product['product_price'])
            ];
        }
    }
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'add-to-wishlist'){
    $id         = (int)$_POST['id'];
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        if(DB::rowCount("SELECT * FROM wishlist WHERE user_id = $userID AND product_id = $id") > 0){
            $error[] = 'Product is exists';
        } else {
            try{
                DB::execute("INSERT INTO wishlist VALUES(null, $id, $userID)");
            }catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
        if(count($error)==0) $status = 'success';
    } else {
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        if(!in_array($id,$wishlist)){
            $wishlist[] = $id;
            $status = 'success';
        } else {
            $status = 'error';
        }
        //setcookie('cart', json_encode($cart));
        setcookie('wishlist', json_encode($wishlist), time() + 360000, "/");
    }
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'remove-wishlist'){
    $id = (int)$_POST['id'];
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        try{
            DB::execute("DELETE FROM wishlist WHERE product_id = $id AND user_id = $userID");
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
    } else {
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        $key = array_search($id, $wishlist);
        if (false !== $key) {
            unset($wishlist[$key]);
        }
        setcookie('wishlist', json_encode($wishlist), time() + 360000, "/");
    }
    if(count($error) == 0) $status = 'success';
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'wishlist-to-cart'){
    $id = (int)$_POST['id'];
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        $sql = "SELECT * FROM cart WHERE user_id = $userID AND product_id = $id";
        if(DB::rowCount($sql) > 0){
            try{
                DB::execute("UPDATE cart SET product_quantity = product_quantity + 1 WHERE user_id = $userID AND product_id = $id");
            }catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        } else {
            try{
                DB::execute("INSERT INTO cart VALUES(null, $id, 1, $userID)");
            }catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
        try{
            DB::execute("DELETE FROM wishlist WHERE product_id = $id AND user_id = $userID");
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
    } else {
        $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : "[]";
        $cart = json_decode($cart, true);
        if(array_key_exists($id,$cart)){
            $cart[$id] = array(
                'quantity'  => (int)$cart[$id]['quantity'] + 1,
            );
        } else {
            $cart[$id] = array(
                'quantity'  => 1,
            );
        }
        setcookie('cart', json_encode($cart), time() + 360000, "/");
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        $key = array_search($id, $wishlist);
        if (false !== $key) {
            unset($wishlist[$key]);
        }
        setcookie('wishlist', json_encode($wishlist), time() + 360000, "/");
    }
    if(count($error) == 0) $status = 'success';
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'get-array-wishlist'){
    echo arrWishList();
}

?>