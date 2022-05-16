<?php
require_once 'config.php';
Session::destroy();
header('Location: '.ROOT_URL.'/home');
?>