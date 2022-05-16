<?php
require_once 'require.php';
$status = 'error';
$error  = array();
if(isset($_POST['action']) && $_POST['action'] == 'update-information'){
    $webName    = handleField($_POST['website-name']);
    $webAddress = handleField($_POST['website-address']);
    $webEmail   = handleField($_POST['website-email']);
    $webPhone   = handleField($_POST['website-phone']);
    $webLogo    = $_FILES['weblogo'];
    try{
        $sql = "UPDATE web_settings SET web_title = '$webName', web_address = '$webAddress', web_email = '$webEmail', web_phone = '$webPhone' WHERE web_id = 1";
        DB::execute($sql);
        if($webLogo['size'] > 0){
            $fileExtension = pathinfo($webLogo['name'], PATHINFO_EXTENSION);
            $fileName = 'logo-'.randomStr().'.'.$fileExtension;
            move_uploaded_file($webLogo['tmp_name'], '../assets/uploads/logo/'.$fileName);
            $sql = "UPDATE web_settings SET web_logo = '$fileName' WHERE web_id = 1";
            DB::execute($sql);
        }
    } catch (PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error) == 0) $status = 'success';
}
$data = array(
    'status'    => $status,
    'message'   => $error
);
echo json_encode($data);
