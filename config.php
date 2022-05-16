<?php
    require_once 'lib/DB.php';
    require_once 'lib/Session.php';
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // define('ROOT_URL', 'http://duan1.pro');
    define('ROOT_URL', $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"]);
    
    define('SITE_KEY', '6LdhyZEdAAAAAKKT-pnuk8QmOS8bh7l0ewO1DweL');

    define('SECRET_KEY', '6LdhyZEdAAAAAEc1INN1f0IKjL9yxB1mHcvaQgct');
    // database init
    DB::init();
    // session init
    Session::init();
    // define web setting
    $config = DB::getSettings();
    define('WEB_TITLE', $config['web_title']);
    define('WEB_LOGO', $config['web_logo']);
    define('WEB_ADDRESS', $config['web_address']);
    define('WEB_PHONE', $config['web_phone']);
    define('WEB_EMAIL', $config['web_email']);
