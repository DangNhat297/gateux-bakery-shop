<?php
$fileCurrent = str_replace('/', '', $_SERVER['SCRIPT_NAME']);
switch($fileCurrent){
    case 'profile.php':
        Session::checkSessionClient();
    break;
}
Session::updateUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--meta open graph-->
    <meta property="og:image" content="https://i.imgur.com/5Z9ltMN.png" />
    <meta property="og:url" content="<?=ROOT_URL?>" />
    <meta property="og:title" content="<?=WEB_TITLE?>" />
    <meta property="og:type" content="Website" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:description" content="Gateux | Cake Store" />
    <meta property="og:site_name" content="<?=WEB_TITLE?>" />
    <!--meta end-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/rateit.css" />
    <link rel="icon" href="<?=ROOT_URL?>/assets/img/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/global.css?t=<?= randomStr() ?>" />
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/rateit.css" />
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/auth.css?t=<?= randomStr() ?>" />
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/toastr.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/main.css?t=<?= randomStr() ?>" />    <!--Begin::JQuery-->
    <script src="<?=ROOT_URL?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        // preloading
        $(document).ready(function(){
            setTimeout(()=>{
                $('.pre-loading').fadeOut(500)
            },1000)
        })
    </script>
    <!--End::Jquery-->
    <!--Preloader-->
    <link rel="stylesheet" href="<?=ROOT_URL?>/assets/css/loaders.css">
    <!--Preloader end-->
    <!--reCaptcha-->  
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <!--reCatpcha end-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js"></script>
    <script>
        const ROOT_URL = '<?=ROOT_URL?>'
    </script>
    <title><?=WEB_TITLE?></title>
</head>

<body id="scroll-custom">
<noscript>Your browser does not support JavaScript!</noscript>
<div class="pre-loading">
<div class="loader">
        <div class="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
</div>