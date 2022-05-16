<?php
function checkLength($name, $min, $max){
    $flag = false;
    if(strlen($name) >= $min && strlen($name) <= $max) $flag = true;
    return $flag;
}
function checkExtension($filename, $extension = ['jpg','png','jfif','jpeg']){
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    $flag = false;
    if(in_array(strtolower($file_extension), $extension)) $flag = true;
    return $flag;
}
function checkFileSize($filesize, $min, $max){
    $flag = false;
    if($filesize >= $min && $filesize <= $max) $flag = true;
    return $flag;
}
function randomStr(){
    $str = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890";
    $str = str_shuffle($str);
    return substr($str, 0, 5);
}
// function product_price($priceFloat) {
//     $symbol = 'đ';
//     $symbol_thousand = '.';
//     $decimal_place = 0;
//     $price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
//     return $price.$symbol;
// }
function product_price($price){
    return '$'.number_format($price, 2,'.', ',');
}
function slug($str){

    $unicode = array(

        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

        'd'=>'đ',

        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

        'i'=>'í|ì|ỉ|ĩ|ị',

        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'D'=>'Đ',

        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach($unicode as $nonUnicode=>$uni){

        $str = preg_replace("#($uni)#i", $nonUnicode, $str);

    }
    $str = strtolower($str);
    $str = preg_replace("#[^a-zA-Z0-9\s]#",'',$str);
    $str = preg_replace("#\s#",'-',$str);
    $str = preg_replace("#(-){2,}#",'-',$str);
    return $str;
}
function handleField($text){
    $text = trim($text);
    $text = strip_tags($text);
    $text = preg_replace("#(\'|\")#i","",$text);
    return $text;
}
function issetWishlist($id){
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        if(DB::rowCount("SELECT * FROM wishlist WHERE user_id = $userID AND product_id = $id") > 0){
            return true;
        }
    } else {
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        if(in_array($id,$wishlist)) return true;
    }
    return false;
}
function arrWishList(){
    $wishlist = [];
    if(Session::issetSession('user')){
        $userID = Session::get('user')['id'];
        $sql = "SELECT * FROM wishlist WHERE user_id = $userID";
        if(DB::rowCount($sql) > 0){
            foreach(DB::fetchAll($sql) as $value){
                $wishlist[] = (int)$value['product_id'];
            }
            return json_encode($wishlist);
        }
    } else {
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        return json_encode($wishlist);
    }
}
function roundNumber($float){
    return round($float, 1, PHP_ROUND_HALF_UP);
}
function showTime($time){
    $currentTime = date("Y-m-d H:i:s");
    $datePost = date_parse_from_format('Y-m-d H:i:s', $time);
    $dateCurrent = date_parse_from_format('Y-m-d H:i:s', $currentTime);
    $current = mktime($dateCurrent['hour'], $dateCurrent['minute'], $dateCurrent['second'], $dateCurrent['month'], $dateCurrent['day'], $dateCurrent['year']);
    $post = mktime($datePost['hour'], $datePost['minute'], $datePost['second'], $datePost['month'], $datePost['day'], $datePost['year']);
    $distance = $current-$post;
    $result = '';
    if($distance < 60){
        $result = 'Just now';
    } else if($distance >= 60 && $distance < 3600){
        $minute = round($distance / 60);
        $result = ($minute == 1) ? $minute . ' minute ago' : $minute . ' minutes ago'; 
    } else if($distance >= 3600 && $distance < 86400){
        $hour = round($distance / 3600);
        $result = ($hour == 1) ? $hour . ' hour ago' : $hour . ' hours ago';
    } else if(round($distance/86400) == 1){
        $hour = round($distance / 3600);
        $result = 'Yesterday at ' . date("H:i:s", $post);
    } else {
        $result = date("d-m-Y \a\\t H:i", $post);
    }
    return $result;
}
?>