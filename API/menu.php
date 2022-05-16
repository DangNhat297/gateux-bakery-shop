<?php
require_once 'require.php';
$status = 'error';
$error  = array();
if (isset($_POST['action']) && $_POST['action'] == 'update-menu') {
    $menuTitle = explode(",", $_POST['menuTitle']);
    $menuUrl = explode(",", $_POST['menuUrl']);
    $menuParent = explode(",", $_POST['menuParent']);
    DB::execute('TRUNCATE menu');
    for ($i = 0; $i < $_POST['item_count']; $i++) {
        try {
            $sql = "INSERT INTO menu (menu_title, menu_url, menu_parent) VALUES ('$menuTitle[$i]','$menuUrl[$i]'," . (int)$menuParent[$i] . " ); ";
            DB::execute($sql);
        } catch (PDOException $e) {
            $error[] = $e->getMessage();
        }
    }
    if (count($error) == 0) $status = 'success';
    $data = array(
        'status'    => $status,
        'message'   => $error
    );
    echo json_encode($data);
}


if (isset($_POST['menu_id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $menuId = (int)$_POST['menu_id'];
    try {
        $sql      = "DELETE FROM menu WHERE menu_id = $menuId";
        DB::execute($sql);
    } catch (PDOException $e) {
        $error[] = $e->getMessage();
    }
    if (count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
