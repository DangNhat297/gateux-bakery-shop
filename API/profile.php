<?php
require_once 'require.php';
$status = 'error';
$error  = array();
if(isset($_POST['action']) && $_POST['action'] == 'update-current-user'){
    $address = handleField($_POST['address']);
    $phone   = handleField($_POST['phone']);
    $userID = Session::get('user')['id'];
    if($_FILES['avatar']['size'] > 0){
        if(!checkExtension($_FILES['avatar']['name'])){
            $error['avatar'] = 'The image file format is incorrect';
        } else {
            $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $fileName = 'avatar-'.randomStr().'.'.$fileExtension;
        }
    }
    if(count($error) == 0){
        try{
            $sql = "UPDATE users SET user_address = '$address', user_phone = '$phone' WHERE user_id = $userID";
            DB::execute($sql);
            if($_FILES['avatar']['size'] > 0){
                try{
                    $sql = "UPDATE users SET user_avatar = '$fileName' WHERE user_id = $userID";
                    DB::execute($sql);
                    move_uploaded_file($_FILES['avatar']['tmp_name'], '../assets/uploads/avatar/' . $fileName);
                } catch (PDOException $e){
                    $error[] = $e->getMessage();
                }
            }
        } catch (PDOException $e){
            $error[] = $e->getMessage();
        }
    }
    if(count($error) == 0) $status = 'success';
}
$data = [
    'status'    => $status,
    'message'   => $error
];
echo json_encode($data);
?>