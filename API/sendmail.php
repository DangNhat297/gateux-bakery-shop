<?php
require_once 'require.php';
// require lib php mailer
require_once '../lib/PHPMailer/class.phpmailer.php';
require_once '../lib/PHPMailer/class.smtp.php';
$error = array();
$status = 'error';
$email = 'linhloi2k2@gmail.com';
try{
    // start mailer 
    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";
    $message = file_get_contents('../lib/email_template/order_confirm.html');
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
$data = [
    'status'    => $status,
    'message'   => $error
];
echo json_encode($data);
?>