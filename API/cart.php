<?php
require_once 'require.php';
$status     = 'error';
$error      = array();
if(isset($_POST['get']) && $_POST['get'] == 'list-cart'){
    $data = array();
    $sum = 0;
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        $listCart = DB::fetchAll("SELECT cart.cart_id, cart.product_quantity, product.product_name,product.product_price, product.product_discount, product.product_thumb FROM cart, product WHERE cart.product_id = product.product_id AND cart.user_id = $userID");
        foreach($listCart as $cart){
            $data[] = array(
                'id'        => $cart['cart_id'],
                'image'     => $cart['product_thumb'],
                'name'      => $cart['product_name'],
                'price'     => product_price(($cart['product_discount'] > 0) ? $cart['product_price'] - ($cart['product_price']*$cart['product_discount']/100) : $cart['product_price']),
                'quantity'  => $cart['product_quantity'],
                'total'     => product_price((($cart['product_discount'] > 0) ? $cart['product_price'] - ($cart['product_price']*$cart['product_discount']/100) : $cart['product_price'])*$cart['product_quantity'])
            );
            $sum += (($cart['product_discount'] > 0) ? $cart['product_price'] - ($cart['product_price']*$cart['product_discount']/100) : $cart['product_price'])*$cart['product_quantity'];
        }
    } else {
        $cart = $_COOKIE['cart'] ?? "[]";
        $cart = json_decode($cart, true);
        foreach($cart as $id => $value){
            $product = DB::fetch("SELECT * FROM product WHERE product_id = $id");
            $data[] = array(
                'id'        => $id,
                'image'     => $product['product_thumb'],
                'name'      => $product['product_name'],
                'price'     => product_price(($product['product_discount'] > 0) ? $product['product_price'] - ($product['product_price']*$product['product_discount']/100) : $product['product_price']),
                'quantity'  => $value['quantity'],
                'total'     => product_price((($product['product_discount'] > 0) ? $product['product_price'] - ($product['product_price']*$product['product_discount']/100) : $product['product_price'])*$value['quantity'])
            );
            $sum += (($product['product_discount'] > 0) ? $product['product_price'] - ($product['product_price']*$product['product_discount']/100) : $product['product_price'])*$value['quantity'];
        }
    }
    $cart = array(
        'product'    => $data,
        'sum'       => product_price($sum)
    );
    echo json_encode($cart);
}
if(isset($_POST['action']) && $_POST['action'] == 'add-to-cart'){
    $id         = (int)$_POST['id'];
    $quantity   = (int)$_POST['quantity'];
    $product    = DB::fetch("SELECT * FROM product WHERE product_id = $id");
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        if(DB::rowCount("SELECT * FROM cart WHERE user_id = $userID AND product_id = $id") > 0){
            try{
                DB::execute("UPDATE cart SET product_quantity = product_quantity + $quantity WHERE user_id = $userID AND product_id = $id");
            } catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        } else {
            try{
                DB::execute("INSERT INTO cart VALUES(null, $id, $quantity, $userID)");
            }catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
        if(count($error)==0) $status = 'success';
    } else {
        $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : "[]";
        $cart = json_decode($cart, true);
        if(array_key_exists($id,$cart)){
            $cart[$id] = array(
                'quantity'  => (int)$cart[$id]['quantity'] + $quantity,
            );
        } else {
            $cart[$id] = array(
                'quantity'  => $quantity,
            );
        }
        $status = 'success';
        //setcookie('cart', json_encode($cart));
        setcookie('cart', json_encode($cart), time() + 360000, "/");
    }
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'delete-cart-product'){
    $id = (int)$_POST['id'];
    if(Session::issetSession('user')){
        $userID = $_SESSION['user']['id'];
        try{
            DB::execute("DELETE FROM cart WHERE cart_id = $id AND user_id = $userID");
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
    } else {
        $cart = $_COOKIE['cart'];
        $cart = json_decode($cart, true);
        unset($cart[$id]);
        setcookie('cart', json_encode($cart), time()+360000, "/");
    }
    if(count($error) == 0) $status = 'success';
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'update-cart'){
    $id = (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    if(Session::issetSession('user')){
        try{
            DB::execute("UPDATE cart SET product_quantity = $quantity WHERE cart_id = $id");
        } catch(PDOException){
            $error[] = $e->getMessage();
        }
    } else {
        $cart = $_COOKIE['cart'] ?? "[]";
        $cart = json_decode($cart, true);
        $cart[$id]['quantity'] = $quantity;
        setcookie('cart', json_encode($cart), time()+360000, "/");
    }
    if(count($error) == 0) $status = 'success';
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}
?>