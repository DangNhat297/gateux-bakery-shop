<?php
function get_header($path = "./")
{
    require_once $path . 'config.php';
    require_once $path . 'lib/functions.php';
    require_once $path . 'component/header.php';
}
function get_footer($path = "./")
{
    require_once $path . 'component/footer.php';
}
function get_nav($path = "./")
{
    require_once $path . 'component/nav-bar.php';
}
function get_headerauth()
{
}
