<?php
require_once 'require.php';
$status = 'error';
$error = array();
$date       = new DateTime();
$createdAt   = $date->format("Y-m-d H:i:s");
if(isset($_POST['get']) && $_POST['get'] == 'list-user'){
    $admin      = DB::fetchAll("SELECT user_id, user_name, user_email, user_status FROM users WHERE user_role = 3");
    $staff      = DB::fetchAll("SELECT user_id, user_name, user_email, user_status FROM users WHERE user_role = 2");
    $customer   = DB::fetchAll("SELECT user_id, user_name, user_email, user_status FROM users WHERE user_role = 1");
    $data = [
        'admin'     => $admin,
        'staff'     => $staff,
        'customer'  => $customer
    ];
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'user'){
    $userID = (int)$_POST['id'];
    $user = DB::fetch("SELECT * FROM users WHERE user_id = $userID");
    $date = new DateTime($user['created_at']);
    $createdAt = $date->format("d-m-Y");
    $data = [
        'user_id'       => $user['user_id'],
        'username'      => $user['user_name'],
        'email'         => $user['user_email'],
        'phone'         => $user['user_phone'],
        'address'       => $user['user_address'],
        'avatar'        => $user['user_avatar'],
        'status'        => $user['user_status'],
        'role'          => $user['user_role'],
        'created_at'    => $createdAt   
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'add-user'){
    $username   = handleField($_POST['username']);
    $password   = $_POST['password'];
    $cpassword  = $_POST['cpassword'];
    $role       = (int)$_POST['role'];
    $email      = handleField($_POST['email']);
    if(!checkLength($username, 5, 255)){
        $error['username'] = 'Username must be more than 5 characters';
    } else if(preg_match("#\W#", $username)){
        $error['username'] = 'Username cannot contain special characters';
    } else if(DB::rowCount("SELECT * FROM users WHERE user_name = '$username'") > 0){
        $error['username'] = 'Username already exists';
    }
    if(!preg_match("#(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{6,255}#", $password)){
        $error['password'] = 'Password contains at least 1 numeric character, 1 uppercase letter, 1 lowercase letter, 6 characters or more';
    } else if($password != $cpassword){
        $error['cpassword'] = 'Password confirmation is incorrect, please try again';
    }
    if(DB::rowCount("SELECT * FROM users WHERE user_email = '$email'") > 0){
        $error['email'] = 'Email was registered';
    }
    if(count($error)==0){
        $password   = password_hash($password, PASSWORD_BCRYPT);
        $verifyCode = randomStr();
        $sql = "INSERT INTO users VALUES(null, '$username', '$password', null, null, '$email', 'default.jpg', 1, '$verifyCode', $role, '$createdAt')";
        try{
            DB::execute($sql);
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
    }
    if(count($error)==0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'update-user'){
    $userID = (int)$_POST['modal-user-id'];
    $status = (int)$_POST['modal-user-status'];
    $role = (int)$_POST['modal-user-role'];
    try{
        $sql = "UPDATE users SET user_status = $status, user_role = $role WHERE user_id = $userID";
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
if(isset($_POST['action']) && $_POST['action'] == 'delete-user'){
    $userId = (int)$_POST['id'];
    if($userId == Session::get('user')['id']){
        $error[] = "Can't delete current user";
    } else {
        try{
            $sql      = "DELETE FROM users WHERE user_id = $userId";
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
if(isset($_SESSION['user']) && isset($_POST['action']) && $_POST['action'] == 'change-password'){
    $userID = Session::get('user')['id'];
    $oldPass = $_POST['current-password'];
    $newPass = $_POST['new-password'];
    $confirmPass = $_POST['confirm-password'];
    $user = DB::fetch("SELECT * FROM users WHERE user_id = $userID");
    $currentPass = $user['user_pass'];
    if(!password_verify($oldPass, $currentPass)){
        $error['current-password'] = 'Current password is incorrect';
    } else {
        if(!preg_match("#(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{6,255}#", $newPass)){
            $error['new-password'] = 'Password contains at least 1 numeric character, 1 uppercase letter, 1 lowercase letter, 6 characters or more';
        } else if($newPass != $confirmPass){
            $error['confirm-password'] = 'Password confirmation is incorrect, please try again';
        }
    }
    if(count($error) == 0){
        $password   = password_hash($newPass, PASSWORD_BCRYPT);
        try{
            DB::execute("UPDATE users SET user_pass = '$password' WHERE user_id = $userID");
        }catch(PDOException $e){
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
if(isset($_POST['get']) && $_POST['get'] == 'current-user'){
    $currentUser = [];
    if(Session::issetSession('user')){
        $currentUser = Session::get('user'); 
    }
    echo json_encode($currentUser);
}
?>