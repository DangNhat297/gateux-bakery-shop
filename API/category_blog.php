<?php
require_once 'require.php';
$error  = [];
$status = 'error';
$date       = new DateTime();
$createdAt   = $date->format("Y-m-d H:i:s");
if(isset($_POST['get']) && $_POST['get'] == 'list-category'){
    $sql = "SELECT * FROM category_blog ORDER BY cate_id DESC";
    $listCategory = DB::fetchAll($sql);
    $data = [];
    foreach($listCategory as $category){
        $date = new DateTime($category['cate_date']);
        $datetime = $date->format("d-m-Y \a\\t H:i");
        $data[] = array(
            'cate_id'       => $category['cate_id'],
            'cate_name'     => $category['cate_name'],
            'created_at'    => $datetime 
        );
    }
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'category'){
    $category = (int)$_POST['category'];
    $sql = "SELECT * FROM category_blog WHERE cate_id = $category";
    $result = DB::fetch($sql);
    $date = new DateTime($result['cate_date']);
    $datetime = $date->format("d-m-Y \a\\t H:i");
    $data = array(
        'cate_id'      => $result['cate_id'],
        'cate_name'    => $result['cate_name'],
        'created_at'  => $datetime
    );
    echo json_encode($data);
}
if(isset($_POST['category']) && isset($_POST['action']) && $_POST['action'] == 'add-category'){
    $category = handleField($_POST['category']);
    $sql      = "SELECT * FROM category_blog WHERE cate_name = '$category'";
    if(DB::rowCount($sql) > 0){
        $error['category'] = 'Category name already exists';
    } else {
        $sql  = "INSERT INTO category_blog(cate_name,cate_date) VALUES ('$category','$createdAt')";
        try{
            DB::execute($sql);
        } catch(PDOException $e){
            $error['category'] = 'Error: '. $e->getMessage();
        };
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['category_name']) && isset($_POST['action']) && $_POST['action'] == 'update'){
    $category = handleField($_POST['category_name']);
    $id       = (int)$_POST['id'];
    $sql      = "SELECT * FROM category_blog WHERE cate_name = '$category' AND cate_id <> $id";
    if(DB::rowCount($sql) > 0){
        $error['category'] = 'Category name already exists';
    } else {
        $sql  = "UPDATE category_blog SET cate_name = '$category' WHERE cate_id = $id";
        try{
            DB::execute($sql);
        }catch(PDOException $e){
            $error['category'] = $e->getMessage();
        }
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['category']) && isset($_POST['action']) && $_POST['action'] == 'delete'){
    $category = (int)$_POST['category'];
    try{
        $sql      = "DELETE FROM category_blog WHERE cate_id = $category";
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
?>