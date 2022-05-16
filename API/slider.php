<?php
require_once 'require.php';
$status = 'error';
$error  = array();
if (isset($_POST['action']) && $_POST['action'] == 'update-slider') {
    $sliderTitle = explode(",", $_POST['sliderTitle']);
    $sliderUrl = explode(",", $_POST['sliderUrl']);
    $sliderImg = explode(",", $_POST['sliderImg']);
    DB::execute('TRUNCATE slider');
    for ($i = 0; $i < $_POST['item_count']; $i++) {
        try {
            $sql = "INSERT INTO slider (slider_img, slider_title, slider_url) VALUES ('$sliderImg[$i]','$sliderTitle[$i]','$sliderUrl[$i]' ) ";
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

if (isset($_POST['slider_id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $sliderId = (int)$_POST['slider_id'];
    try {
        $sql      = "DELETE FROM slider WHERE slider_id = $sliderId";
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
