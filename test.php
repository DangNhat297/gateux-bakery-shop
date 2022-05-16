<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$getTime     = date("Y-m-d H:i:s");
// $currentTime = date("Y-m-d H:i:s");
$currentTime     = "2021-12-07 23:59:59";
$datePost = date_parse_from_format('Y-m-d H:i:s', $getTime);
$dateCurrent = date_parse_from_format('Y-m-d H:i:s', $currentTime);
echo '<pre>';
print_r($datePost);
echo '</pre>';
echo '<pre>';
print_r($dateCurrent);
echo '</pre>';
$current = mktime($dateCurrent['hour'], $dateCurrent['minute'], $dateCurrent['second'], $dateCurrent['month'], $dateCurrent['day'], $dateCurrent['year']);
$post = mktime($datePost['hour'], $datePost['minute'], $datePost['second'], $datePost['month'], $datePost['day'], $datePost['year']);
echo $current;
echo '<br>'.$post;
echo '<br>'. (int)$distance = $current-$post;
// 20 seconds ago
// 20 minutes ago
// 2 hours ago
// yesterday at 09:20
// 05/12/2021 at 09:20
$result = '';
// switch($distance){
//     case $distance < 60:
//         $result = 'Just now';
//         break;
//     case ($distance >= 60 && $distance < 3600):
//         $minute = round($distance / 60);
//         $result = ($minute == 1) ? $minute . ' minute ago' : $minute . ' minutes ago'; 
//         break;
//     case ($distance >= 3600 && $distance < 86400):
//         $hour = round($distance / 3600);
//         $result = ($hour == 1) ? $hour . ' hour ago' : $hour . ' hours ago'; 
//         break;
//     case (round($distance/86400) == 1):
//         $hour = round($distance / 3600);
//         $result = 'Yesterday at ' . date("H:i:s", $post);
//         break;
//     default: 
//         $result = date("d-m-Y \a\\t H:i", $post);
//         break;
// }
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
echo '<br>'. $result;
?>