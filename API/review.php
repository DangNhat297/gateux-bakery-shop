<?php
require_once 'require.php';
$error = array();
$status = 'success';
if(isset($_POST['get']) && $_POST['get'] == 'list-review'){
    $sql = "SELECT product.product_id, product.product_name, COUNT(review.product_id) as quantity, MAX(review.review_date) as moinhat, MIN(review.review_date) as cunhat, AVG(review.review_rating) as rating FROM product, review WHERE product.product_id = review.product_id GROUP BY product.product_id HAVING quantity > 0;";
    $listCmt = DB::fetchAll($sql);
    $data = array();
    foreach($listCmt as $cmt){
        $date = new DateTime($cmt['moinhat']);
        $newTime = $date->format("d-m-Y \a\\t H:i");
        $date = new DateTime($cmt['cunhat']);
        $oldTime = $date->format("d-m-Y \a\\t H:i");
        $data[] = array(
            'product_id'    => $cmt['product_id'],
            'name'          => $cmt['product_name'],
            'quantity'      => $cmt['quantity'],
            'rating'        => roundNumber($cmt['rating']),
            'new'          => $newTime,
            'last'           => $oldTime
        );
    }
    echo json_encode($data);
}
// admin 
if(isset($_POST['get']) && $_POST['get'] == 'product-review-list'){
    $productID = (int)$_POST['id'];
    $sql = "SELECT review.review_id, users.user_id, users.user_name, users.user_avatar, users.user_role, review.review_content, review.review_date, review.review_rating, review.review_parent_id FROM users, review, product WHERE review.user_id = users.user_id AND review.product_id = product.product_id AND review.product_id = $productID AND review.review_parent_id is null ORDER BY review.review_id ASC";
    $listReviewProduct = DB::fetchAll($sql);
    $detail = array();
    $children = array();
    $product = DB::fetch("SELECT product_id,product_name FROM product WHERE product_id = $productID");
    foreach($listReviewProduct as $key=>$review){
        $date = new DateTime($review['review_date']);
        $time = $date->format("d-m-Y \a\\t H:i");
        $children = [];
        $detail[$key] = array(
            'review_id'     => $review['review_id'],
            'user_id'       => $review['user_id'],
            'username'      => $review['user_name'],
            'user_avatar'   => $review['user_avatar'],
            'user_role'     => $review['user_role'],
            'content'       => $review['review_content'],
            'time'          => $time,
            'rating'        => $review['review_rating'],
            'review_parent_id' => $review['review_parent_id'],
            'children'      => $children
        );
        $child = DB::fetchAll("SELECT review.review_id, users.user_name, users.user_avatar, users.user_role, review.review_content, review.review_date, review.review_rating, review.review_parent_id FROM users, review WHERE review.user_id = users.user_id AND review.review_parent_id = " . $review['review_id'] . " ORDER BY review.review_id ASC");
        foreach($child as $item){
            $date = new DateTime($item['review_date']);
            $time = $date->format("d-m-Y \a\\t H:i");
            $children[] = array(
                'review_id'     => $item['review_id'],
                'username'      => $item['user_name'],
                'user_avatar'   => $item['user_avatar'],
                'user_role'     => $item['user_role'],
                'content'       => $item['review_content'],
                'time'          => $time,
                'review_parent_id' => $item['review_parent_id'],
            );
        }
        $detail[$key]['children'] = $children;
    }
    $data = [
        'id'        => $product['product_id'],
        'name'      => $product['product_name'],
        'product'   => $detail
    ];
    echo json_encode($data);
}
// client
if(isset($_POST['get']) && $_POST['get'] == 'product-review-list-html'){
    $xhtml = '';
    $productID = (int)$_POST['id'];
    $sql = "SELECT review.review_id, users.user_id, users.user_name, users.user_avatar, users.user_role, review.review_content, review.review_date, review.review_rating, review.review_parent_id FROM users, review, product WHERE review.user_id = users.user_id AND review.product_id = product.product_id AND review.product_id = $productID AND review.review_parent_id is null ORDER BY review.review_id ASC";
    $listReviewProduct = DB::fetchAll($sql);
    $detail = array();
    $children = array();
    $product = DB::fetch("SELECT product_id,product_name FROM product WHERE product_id = $productID");
    foreach($listReviewProduct as $key=>$review){
        $time = showTime($review['review_date']);
        $children = [];
        $detail[$key] = array(
            'review_id'     => $review['review_id'],
            'user_id'       => $review['user_id'],
            'username'      => $review['user_name'],
            'user_avatar'   => $review['user_avatar'],
            'user_role'     => $review['user_role'],
            'content'       => $review['review_content'],
            'time'          => $time,
            'rating'        => $review['review_rating'],
            'review_parent_id' => $review['review_parent_id'],
            'children'      => $children
        );
        $child = DB::fetchAll("SELECT review.review_id,users.user_id, users.user_name, users.user_avatar, users.user_role, review.review_content, review.review_date, review.review_rating, review.review_parent_id FROM users, review WHERE review.user_id = users.user_id AND review.review_parent_id = " . $review['review_id'] ." ORDER BY review.review_id ASC");
        foreach($child as $item){
            $time = showTime($item['review_date']);
            $children[] = array(
                'review_id'     => $item['review_id'],
                'user_id'       => $item['user_id'],
                'username'      => $item['user_name'],
                'user_avatar'   => $item['user_avatar'],
                'user_role'     => $item['user_role'],
                'content'       => $item['review_content'],
                'time'          => $time,
                'review_parent_id' => $item['review_parent_id'],
            );
        }
        $detail[$key]['children'] = $children;
    }
    // xu ly html
    foreach($detail as $parent){
        $xhtml .= '<div class="review-item">
                        <div class="review-item__parent">
                            <div class="review-item__avatar">
                                <img src="'.ROOT_URL.'/assets/uploads/avatar/'.$parent['user_avatar'].'">
                            </div>
                            <div class="review-item__detail">
                                <div class="review-item__user" data-review-id="'.$parent['review_id'].'">
                                    <div class="review-item__info">
                                        <div class="review-item__name">'.$parent['username'].'</div>';
        if($parent['user_role'] == 3){
            $xhtml .= '<div class="review-item__user--badge admin">Admin</div>';
        } else if($parent['user_role'] == 2){
            $xhtml .= '<div class="review-item__user--badge staff">Staff</div>';
        } else {
            $xhtml .= '<div class="review-item__user--badge member">Member</div>';
        }
                    $xhtml .= '<div class="review-item__time">'.$parent['time'].'</div>
                                    </div>';
        if(Session::issetSession('user')){
            $xhtml .= '<div class="review-item__btn">';
                if(Session::get('user')['role'] == 3 || Session::get('user')['role'] == 2){
                    $xhtml .= '<button data-toggle="tooltip" class="review-item__btn--reply" title="Reply" data-placement="top"><i class="fas fa-reply"></i></button>';
                }
                if(Session::get('user')['id'] == $parent['user_id'] || (Session::get('user')['role'] == 3 || Session::get('user')['role'] == 2)){
                    $xhtml .= '<button data-toggle="tooltip" class="review-item__btn--delete" data-review-id="'.$parent['review_id'].'" title="Delete" data-placement="top"><i class="fas fa-trash-alt"></i></button>';
                }    
            $xhtml .= '</div>';
        }                            
                    $xhtml .='</div>
                                <div class="review-item__rating"><div class="user-rating" data-rateit-value="'.$parent['rating'].'"></div></div>
                                <div class="review-item__content">'.$parent['content'].'</div>
                            </div>
                        </div>';
        if(count($parent['children']) > 0){
            foreach($parent['children'] as $child){
                $xhtml .= '<div class="review-item__reply">
                                <div class="review-item__avatar">
                                    <img src="'.ROOT_URL.'/assets/uploads/avatar/'.$child['user_avatar'].'">
                                </div>
                                <div class="review-item__detail">
                                    <div class="review-item__user">
                                        <div class="review-item__info">
                                            <div class="review-item__name">'.$child['username'].'</div>';
                                            if($child['user_role'] == 3){
                                                $xhtml .= '<div class="review-item__user--badge admin">Admin</div>';
                                            } else if($child['user_role'] == 2){
                                                $xhtml .= '<div class="review-item__user--badge staff">Staff</div>';
                                            } else {
                                                $xhtml .= '<div class="review-item__user--badge member">Member</div>';
                                            }
                                            $xhtml .= '<div class="review-item__time">'.$child['time'].'</div>
                                        </div>';
                    if(Session::issetSession('user')){
                        if(Session::get('user')['id'] == $child['user_id'] || (Session::get('user')['role'] == 3 || Session::get('user')['role'] == 2)){
                            $xhtml .= '<div class="review-item__btn">
                                    <button data-toggle="tooltip" class="review-item__btn--delete" data-review-id="'.$child['review_id'].'" title="Delete" data-placement="top"><i class="fas fa-trash-alt"></i></button>
                                </div>';
                        }
                    }                    
                    $xhtml .= '</div>
                                    <div class="review-item__content">'.$child['content'].'</div>
                                </div>
                            </div>';
            }
        }                
        $xhtml .= '</div>';
    }
    echo $xhtml;
}
if(isset($_POST['action']) && $_POST['action'] == 'delete-review'){
    $id = (int)$_POST['id'];
    try{
        DB::execute("DELETE FROM review WHERE review_parent_id = $id");
        DB::execute("DELETE FROM review WHERE review_id = $id");
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
if(isset($_POST['action']) && $_POST['action'] == 'add-review'){
    $wordError = "fuck|cunt|dcm|dm|cc|dkm|clmm|cmm|\'|\"";
    $content = handleField($_POST['content']);
    $rating = $_POST['rating'];
    $content = preg_replace("#($wordError)#i", "***", $content);
    $userID = Session::get('user')['id'];
    $productID = (int)$_POST['id'];
    try{
        DB::execute("INSERT INTO review(review_content,review_rating,review_parent_id,product_id,user_id) VALUES('$content', $rating, null, $productID, $userID)");
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
if(isset($_POST['action']) && $_POST['action'] == 'reply-review'){
    $wordError = "fuck|cunt|dcm|dm|cc|dkm|clmm|cmm";
    $content = handleField($_POST['content']);
    $content = preg_replace("#($wordError)#i", "***", $content);
    $userID = Session::get('user')['id'];
    $productID = (int)$_POST['product'];
    $reviewID = (int)$_POST['id'];
    try{
        DB::execute("INSERT INTO review(review_content,review_rating,review_parent_id,product_id,user_id) VALUES('$content', null, $reviewID, $productID, $userID)");
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
?>