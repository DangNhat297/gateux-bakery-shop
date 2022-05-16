<?php
require_once 'require.php';
$error = array();
$status = 'error';
// require lib php mailer
require_once '../lib/PHPMailer/class.phpmailer.php';
require_once '../lib/PHPMailer/class.smtp.php';
if(isset($_POST['action']) && $_POST['action'] == 'checkout'){
    $xhtml      = '';
    $fullname   = handleField($_POST['fullname']);
    $phone      = handleField($_POST['phone']);
    $email      = handleField($_POST['email']);
    $address    = handleField($_POST['address']);
    $note       = handleField($_POST['note']);
    $userID     = Session::get('user')['id'];
    $sql = "INSERT INTO orders(order_fullname,order_address,order_phone,order_email,order_status,order_note,user_id) VALUES('$fullname', '$address', '$phone', '$email', 1, '$note', $userID)";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    $orderID = DB::lastInsertID();
    $sql = "SELECT product.product_name, product.product_price, product.product_discount, cart.* FROM product, cart WHERE product.product_id = cart.product_id AND user_id = $userID";
    $listCart = DB::fetchAll($sql);
    $data = [];
    foreach($listCart as $product){
        $data[] = [
            'id'        => $product['product_id'],
            'name'      => $product['product_name'],
            'quantity'  => $product['product_quantity'],
            'price'     => ($product['product_discount'] > 0) ? ($product['product_price'] - ($product['product_price']*$product['product_discount']/100)) : $product['product_price']
        ];
    }
    foreach($data as $product){
        $id         = $product['id'];
        $quantity   = $product['quantity'];
        $price      = $product['price'];
        $sql = "INSERT INTO order_detail VALUES($id, $orderID, $quantity, $price)";
        try{
            DB::execute($sql);
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
        $xhtml .= '<tr>
                        <td class="text-left">'.$product['name'].'</td>
                        <td>'.$product['quantity'].'</td>
                        <td>'.product_price($product['price']).'</td>
                        <td class="text-right text-color-pink">'.product_price($product['quantity']*$product['price']).'</td>
                    </tr>';
    }
    $totalPrice = array_reduce($data, function($value, $i){
        $value += $i['price']*$i['quantity'];
        return $value;
    },0);
    // send mail 
    try{
        // start mailer 
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $message = file_get_contents('../lib/email_template/order_confirm.html');
        $message = str_replace('{{date}}',date('M d, Y'),$message);
        $message = str_replace('{{fullname}}',$fullname,$message);
        $message = str_replace('{{phone}}',$phone,$message);
        $message = str_replace('{{email}}',$email,$message);
        $message = str_replace('{{address}}',$address,$message);
        $message = str_replace('{{note}}',$note,$message);
        $message = str_replace('{{details}}',$xhtml,$message);
        $message = str_replace('{{sum}}',product_price($totalPrice),$message);
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "smtp.gmail.com"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = 'ssl';
        $mail->Username = "vinhmatic5x@gmail.com"; // your SMTP username or your gmail username
        $mail->Password = "yyrlddnaqdoapaxh"; // your SMTP password or your gmail password
        $from   = "admin@gateux.store"; // Reply to this email
        $to     = $email; // Recipients email ID
        $name="Gateux"; // Recipient's name
        $mail->From = $from;
        $mail->FromName = "Gateux"; // Name to indicate where the email came from when the recepient received
        $mail->AddAddress($to,$name);
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = "Gateux Order Confirmation";
        $mail->MsgHTML($message);
        //$mail->SMTPDebug = 2;
        if(!$mail->Send())
        {
            $error['system'] = 'Error sending registration email';
        }
    } catch(PDOException $e){
        $error['system'] = 'Error sending registration email';
    }
    try{
        DB::execute("DELETE FROM cart WHERE user_id = $userID");
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error)==0) $status = 'success';
    $result = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($result);
}
if(isset($_POST['get']) && $_POST['get'] == 'list-order'){
    $listOrder = DB::fetchAll("SELECT orders.*, SUM(order_detail.product_quantity*order_detail.product_price) as total FROM orders, order_detail WHERE orders.order_id = order_detail.order_id GROUP BY orders.order_id");
    $dataOrder = [];
    foreach($listOrder as $order){
        $date = new DateTime($order['order_date']);
        $orderDate = $date->format("M d, Y");
        $dataOrder[] = [
            'id'        => $order['order_id'],
            'fullname'  => $order['order_fullname'],
            'phone'     => $order['order_phone'],
            'email'     => $order['order_email'],
            'address'   => $order['order_address'],
            'status'    => $order['order_status'],
            'total'     => product_price($order['total']),
            'note'      => $order['order_note'],
            'date'      => $orderDate
        ];
    }
    echo json_encode($dataOrder);
}
if(isset($_POST['get']) && $_POST['get'] == 'list-order-user'){
    $xhtml = '';
    $userID = Session::get('user')['id'];
    $listOrder = DB::fetchAll("SELECT orders.*, SUM(order_detail.product_quantity*order_detail.product_price) as total FROM orders, order_detail WHERE orders.order_id = order_detail.order_id AND orders.user_id = $userID GROUP BY orders.order_id");
    $dataOrder = [];
    foreach($listOrder as $order){
        $date = new DateTime($order['order_date']);
        $orderDate = $date->format("M d, Y");
        $dataOrder[] = [
            'id'        => $order['order_id'],
            'status'    => $order['order_status'],
            'total'     => $order['total'],
            'date'      => $orderDate
        ];
    }
    foreach($dataOrder as $order){
        $xhtml .= '<tr>
                        <td>#'.$order['id'].'</td>';
        if($order['status'] == 0){
            $xhtml .= '<td class="cancel">Cancel</td>';
        } else if($order['status'] == 1){
            $xhtml .= '<td class="pending">Pending</td>';
        } else if($order['status'] == 2){
            $xhtml .= '<td class="shipping">Shipping</td>';
        } else {
            $xhtml .= '<td class="success">Success</td>';
        }           
        $xhtml .= '<td>'.product_price($order['total']).'</td>
                        <td>'.$order['date'].'</td>
                        <td class="col-btn-action">
                        <button class="detail-order" data-modal-delay="500" data-order-id="'.$order['id'].'" data-toggle="tooltip" title="Detail Order" data-placement="top" data-modal="modal" data-target="#order-detail"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></button>';
        if($order['status'] == 1){
            $xhtml .= '<button class="cancel-order" data-order-id="'.$order['id'].'" data-toggle="tooltip" title="Cancel Order" data-placement="top"><i class="fas fa-times"></i></button>';
        }
        $xhtml .= '</td>
                    </tr>';
    }
    echo $xhtml;
}
if(isset($_POST['get']) && $_POST['get'] == 'detail-order'){
    $orderID = (int)$_POST['id'];
    $xhtml = '';
    $order = DB::fetch("SELECT * FROM orders WHERE order_id = $orderID");
    $orderDetail = DB::fetchAll("SELECT product.product_thumb, product.product_name, order_detail.*, order_detail.product_quantity*order_detail.product_price as amount FROM product, order_detail WHERE product.product_id = order_detail.product_id AND order_id = $orderID");
    $sum = array_reduce($orderDetail, function($sum, $val){
        $sum += $val['amount'];
        return $sum;
    },0);
    $xhtml .= '<div class="order-col-left">
                    <div class="title-block">
                        <h5>Order Detail</h5>
                        <p>#'.$order['order_id'].'</p>
                    </div>
                    <table class="order-product-list">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>';
    foreach($orderDetail as $product){
        $xhtml .= '<tr>
                        <td class="img"><img src="'.ROOT_URL.'/assets/uploads/product/'.$product['product_thumb'].'"></td>
                        <td>'.$product['product_name'].'</td>
                        <td>'.$product['product_quantity'].'</td>
                        <td>'.product_price($product['amount']).'</td>
                    </tr>';
    }
    $xhtml .= '</tbody>
                        <tfoot>
                            <tr style="font-size:0.9rem">
                                <th colspan="3">Payment method</th>
                                <th>Payment on delivery</th>
                            </tr>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>'.product_price($sum).'</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="order-col-right">
                    <div class="title-block"><h5>Purchase Information</h5></div>
                    <div class="order-information">
                        <div class="order-information__field">
                            <p>Name</p>
                            <p>'.$order['order_fullname'].'</p>
                        </div>
                        <div class="order-information__field">
                            <p>Phone</p>
                            <p>'.$order['order_phone'].'</p>
                        </div>
                        <div class="order-information__field">
                            <p>Email</p>
                            <p>'.$order['order_email'].'</p>
                        </div>
                        <div class="order-information__field">
                            <p>Address</p>
                            <p>'.$order['order_address'].'</p>
                        </div>
                        <div class="order-information__field">
                            <p>Status</p>';
    if($order['order_status'] == 0){
        $xhtml .= '<p class="status-cancel">Cancel</p>';
    } else if($order['order_status'] == 1){
        $xhtml .= '<p class="status-pending">Pending</p>';
    } else if($order['order_status'] == 2){
        $xhtml .= '<p class="status-shipping">Shipping</p>';
    } else {
        $xhtml .= '<p class="status-success">Success</p>';
    }                      
    $xhtml .= '</div>
                    </div>
                </div>';
    echo $xhtml;
}
if(isset($_POST['action']) && $_POST['action'] == 'cancel-order'){
    $id = (int)$_POST['id'];
    $sql = "UPDATE orders SET order_status = 0 WHERE order_id = $id";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'change-status'){
    $orderID = (int)$_POST['id'];
    $status = (int)$_POST['status'];
    $sql = "UPDATE orders SET order_status = $status WHERE order_id = $orderID";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'delete-order'){
    $orderID = (int)$_POST['id'];
    $sql = "DELETE FROM orders WHERE order_id = $orderID";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'detail-order-admin'){
    $xhtml = '';
    $orderID = (int)$_POST['id'];
    $order = DB::fetch("SELECT * FROM orders WHERE order_id = $orderID");
    $orderDetail = DB::fetchAll("SELECT product.product_thumb, product.product_name, order_detail.*, order_detail.product_quantity*order_detail.product_price as amount FROM product, order_detail WHERE product.product_id = order_detail.product_id AND order_id = $orderID");
    $sum = array_reduce($orderDetail, function($sum, $val){
        $sum += $val['amount'];
        return $sum;
    },0);
    $date = new DateTime($order['order_date']);
    $orderDate = $date->format("M d, Y");
    $xhtml .= '<div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">ORDER DATE</span>
                                <span class="opacity-70">'.$orderDate.'</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">ORDER NO.</span>
                                <span class="opacity-70">#'.$order['order_id'].'</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder">DELIVERED TO.</span>
                                <span class="opacity-70">'.$order['order_fullname'].'
                                <br>'.$order['order_phone'].'
                                <br>'.$order['order_email'].'
                                <br>'.$order['order_address'].'
                                <br>'.$order['order_note'].'</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice header-->
                <!-- begin: Invoice body-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">Ordered Items</th>
                                        <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                        <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="product-detail">';
    foreach($orderDetail as $product){
        $xhtml .= '<tr class="font-weight-boldest">
                        <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                        <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                            <div class="symbol-label" style="background-image: url(../assets/uploads/product/'.$product['product_thumb'].')"></div>
                        </div>
                        '.$product['product_name'].'</td>
                        <td class="text-right pt-7 align-middle">'.$product['product_quantity'].'</td>
                        <td class="text-right pt-7 align-middle">'.product_price($product['product_price']).'</td>
                        <td class="text-primary pr-0 pt-7 text-right align-middle">'.product_price($product['amount']).'</td>
                    </tr>';
    }
    $xhtml .= '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice body-->
                <!-- begin: Invoice footer-->
                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0 mx-0">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold text-muted text-uppercase">PAYMENT TYPE</th>
                                        <th class="font-weight-bold text-muted text-uppercase">PAYMENT STATUS</th>
                                        <th class="font-weight-bold text-muted text-uppercase text-right">TOTAL PAID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-weight-bolder">
                                        <td>Payment on delivery</td>';
    if($order['order_status'] == 0){
        $xhtml .= '<td class="text-danger">Cancel</td>';
    } else if($order['order_status'] == 1){
        $xhtml .= '<td class="text-warning">Pending</td>';
    } else if($order['order_status'] == 1){
        $xhtml .= '<td class="text-primary">Shipping</td>';
    } else {
        $xhtml .= '<td class="text-success">Success</td>';
    }                                
    $xhtml .= '<td class="text-primary font-size-h3 font-weight-boldest text-right">'.product_price($sum).'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>';
    echo $xhtml;
}
?>