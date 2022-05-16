<?php
require_once 'require.php';
// require lib php mailer
require_once '../lib/PHPMailer/class.phpmailer.php';
require_once '../lib/PHPMailer/class.smtp.php';
$error = array();
$status = 'error';
$date       = new DateTime();
$createdAt   = $date->format("Y-m-d H:i:s");
$verifyCode = randomStr();
$captcha    = $_POST['recaptcha'];
$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$captcha}");
$getCaptcha=json_decode($verify);
if(isset($_POST['action']) && $_POST['action'] == 'login'){
    $account = handleField($_POST['account']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE user_name = '$account' OR user_email ='$account'";
            if(DB::rowCount($sql) == 0){
                $error['account'] = 'Account does not exist';
    }
    if(!$getCaptcha->success) {
        $error['recaptcha'] = 'reCaptcha validation error, please try again';
    }
    if(count($error) == 0){
        $sql = "SELECT * FROM users WHERE user_name = '$account' OR user_email = '$account'";
        $user = DB::fetch($sql);
        if(!password_verify($password, $user['user_pass'])){
            $error['password'] = 'Incorrect password';
        } else if($user['user_status'] == 0){
            $error['account'] = 'Account not active';
        } else {
            if(isset($_POST['loginpage']) && $_POST['loginpage'] == 'admin'){
                if($user['user_role'] < 2){
                    $error['account'] = 'You are not allowed to access this page';
                }
            }
        }
        if(count($error) == 0){
            $status = 'success';
            $info = [
                'id'        => $user['user_id'],
                'username'  => $user['user_name'],
                'avatar'    => $user['user_avatar'],
                'role'      => $user['user_role'],
                'email'     => $user['user_email']
            ];
            Session::set('login', true);
            Session::set('user', $info);
            if($_POST['remember'] == 'yes'){
                setcookie('account', $account, time() + 86400, "/");
                setcookie('password', $password, time() + 86400, "/");
                setcookie('remember', true, time() + 86400, "/");
            } else {
                setcookie('account', "", time()-360, "/");
                setcookie('password', "", time()-360, "/");
                setcookie('remember', "", time()-360, "/");
            }
        }
    }
    // check empty cart, if cart have product => import to datatable
    if(count($error) == 0){
        $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : "[]";
        $cart = json_decode($cart, true);
        $userID = Session::get('user')['id'];
        if(count($cart) > 0){
            foreach($cart as $key => $value){
                $quantity = $value['quantity'];
                if(DB::rowCount("SELECT * FROM cart WHERE product_id = $key AND user_id = $userID") == 0){
                    try{
                        DB::execute("INSERT INTO cart VALUES(null, $key, $quantity, $userID)");
                    } catch(PDOException $e){
                        $error[] = $e->getMessage();
                    }
                } else {
                    try{
                        DB::execute("UPDATE cart SET product_quantity = product_quantity + $quantity WHERE product_id = $key AND user_id = $userID");
                    } catch(PDOException $e){
                        $error[] = $e->getMessage();
                    }
                }
            }
        }
        setcookie('cart', "", time()-360, "/");
    }
    // check empty wishlist, if wishlist have product => import to datatable
    if(count($error) == 0){
        $wishlist = isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "[]";
        $wishlist = json_decode($wishlist, true);
        $userID = Session::get('user')['id'];
        if(count($wishlist) > 0){
            foreach($wishlist as $value){
                if(DB::rowCount("SELECT * FROM wishlist WHERE product_id = $value AND user_id = $userID") == 0){
                    try{
                        DB::execute("INSERT INTO wishlist VALUES(null, $value, $userID)");
                    } catch(PDOException $e){
                        $error[] = $e->getMessage();
                    }
                }
            }
        }
        setcookie('wishlist', "", time()-360, "/");
    }
}
if(isset($_POST['action']) && $_POST['action'] == 'register'){
    $username   = handleField($_POST['username']);
    $password   = $_POST['password'];
    $cpassword  = $_POST['cpassword'];
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
    if(!$getCaptcha->success) {
        $error['recaptcha'] = 'reCaptcha validation error, please try again';
    }
    if(count($error) == 0){
        try{
            // start mailer 
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $message = file_get_contents('../lib/email_template/register.html');
            $message = str_replace('{{username}}',$username,$message);
            $message = str_replace('{{urlverify}}',ROOT_URL."/active/?username=$username&code=".md5($verifyCode),$message);
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->Host = "smtp.gmail.com"; // specify main and backup server
            $mail->Port = 465; // set the port to use
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->SMTPSecure = 'ssl';
            $mail->Username = ""; // your SMTP username or your gmail username
            $mail->Password = ""; // your SMTP password or your gmail password
            $from   = "admin@gateux.xyz"; // Reply to this email
            $to     = $email; // Recipients email ID
            $name="Gateux"; // Recipient's name
            $mail->From = $from;
            $mail->FromName = "Gateux"; // Name to indicate where the email came from when the recepient received
            $mail->AddAddress($to,$name);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // send as HTML
            $mail->Subject = "Confirm account registration";
            $mail->MsgHTML($message);
            //$mail->SMTPDebug = 2;
            if(!$mail->Send())
            {
                $error['system'] = 'Error sending registration email';
            }
        } catch(PDOException $e){
            $error['system'] = 'Error sending registration email';
        }
    }
    if(count($error)==0){
        $password   = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users VALUES(null, '$username', '$password', null, null, '$email', 'default.jpg', 0, '$verifyCode', 1, '$createdAt')";
        try{
            DB::execute($sql);
        }catch(PDOException $e){
            $error[] = $e->getMessage();
        }
    }
    if(count($error) == 0) $status = 'success';
}
if(isset($_POST['action']) && $_POST['action'] == 'forgot-password'){
    $account = handleField($_POST['account']);
    $sql = "SELECT * FROM users WHERE user_name = '$account' OR user_email = '$account'";
    if(!$getCaptcha->success) {
        $error['recaptcha'] = 'reCaptcha validation error, please try again';
    }
    if(count($error) == 0){
        if(DB::rowCount($sql)==0){
            $error['account'] = 'Account does not exists';
        } else {
            $user = DB::fetch($sql);
            $email = $user['user_email'];
            $username = $user['user_name'];
            $verifyCode = $user['user_verifycode'];
            try{
                // start mailer 
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $message = file_get_contents('../lib/email_template/recovery.html');
                $message = str_replace('{{username}}',$username,$message);
                $message = str_replace('{{urlrecovery}}',ROOT_URL."/recovery-password/?email=$email&code=".md5($verifyCode),$message);
                $mail->IsSMTP(); // set mailer to use SMTP
                $mail->Host = "smtp.gmail.com"; // specify main and backup server
                $mail->Port = 465; // set the port to use
                $mail->SMTPAuth = true; // turn on SMTP authentication
                $mail->SMTPSecure = 'ssl';
                $mail->Username = ""; // your SMTP username or your gmail username
                $mail->Password = ""; // your SMTP password or your gmail password
                $from   = "admin@gateux.store"; // Reply to this email
                $to     = $email; // Recipients email ID
                $name="Gateux"; // Recipient's name
                $mail->From = $from;
                $mail->FromName = "Gateux"; // Name to indicate where the email came from when the recepient received
                $mail->AddAddress($to,$name);
                $mail->WordWrap = 50; // set word wrap
                $mail->IsHTML(true); // send as HTML
                $mail->Subject = "Recovery Password on Gateux";
                $mail->MsgHTML($message);
                //$mail->SMTPDebug = 2;
                if(!$mail->Send())
                {
                    $error['system'] = 'Error sending registration email';
                }
            } catch(PDOException $e){
                $error['system'] = 'Error sending registration email';
            }
        }
    }
    if(count($error) == 0) $status = 'success';
}
if(isset($_POST['action']) && $_POST['action'] == 'recovery-change-password'){
    $email = handleField($_POST['email']);
    $newPass = $_POST['new-password'];
    $confirmPass = $_POST['confirm-password'];
    if(!preg_match("#(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{6,255}#", $newPass)){
        $error['new-password'] = 'Password contains at least 1 numeric character, 1 uppercase letter, 1 lowercase letter, 6 characters or more';
    } else if($newPass != $confirmPass){
        $error['confirm-password'] = 'Password confirmation is incorrect, please try again';
    }
    if(count($error) == 0){
        $password   = password_hash($newPass, PASSWORD_BCRYPT);
        $newCode = randomStr();
        try{
            DB::execute("UPDATE users SET user_pass = '$password', user_verifycode = '$newCode' WHERE user_email = '$email'");
        }catch(PDOException $e){
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