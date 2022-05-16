<?php
require_once 'require.php';
$status = 'error';
$error = array();
if(isset($_POST['action']) && $_POST['action'] == 'add-contact'){
    $fullName   = handleField($_POST['fullname']);
    $email      = handleField($_POST['email']);
    $title      = handleField($_POST['title']);
    $content    = handleField($_POST['content']);
    $status     = 'success';
    $fileName   = '../admin/crud/contact.txt';
    file_put_contents($fileName, $fullName."|".$email."|".$title."|".$content."\r\n", FILE_APPEND);
    $status = 'success';
}
if(isset($_POST['action']) && $_POST['action'] == 'sub-footer'){
    $email      = handleField($_POST['email']);
    $status     = 'success';
    $fileName   = '../admin/crud/subscribe.txt';
    file_put_contents($fileName, $email."\r\n", FILE_APPEND);
    $status = 'success';
}
$data = [
    'status'    => $status,
    'message'   => $error
];
echo json_encode($data)
?>