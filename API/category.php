<?php
require_once 'require.php';
$error  = [];
$status = 'error';
if(isset($_POST['get']) && $_POST['get'] == 'list-category'){
    $sql = "SELECT * FROM category ORDER BY cate_id DESC";
    $listCategory = DB::fetchAll($sql);
    $data = [];
    foreach($listCategory as $category){
        $date = new DateTime($category['created_at']);
        $datetime = $date->format("d-m-Y \a\\t H:i");
        $data[] = array(
            'cate_id'       => $category['cate_id'],
            'cate_name'     => $category['cate_name'],
            'cate_status'   => $category['cate_status'],
            'created_at'    => $datetime 
        );
    }
    echo json_encode($data);
}
if(isset($_POST['get']) && $_POST['get'] == 'category'){
    $category = (int)$_POST['category'];
    $sql = "SELECT * FROM category WHERE cate_id = $category";
    $result = DB::fetch($sql);
    $date = new DateTime($result['created_at']);
    $datetime = $date->format("d-m-Y \a\\t H:i");
    $data = array(
        'cate_id'      => $result['cate_id'],
        'cate_name'    => $result['cate_name'],
        'cate_thumb'   => $result['cate_thumb'],
        'created_at'  => $datetime
    );
    echo json_encode($data);
}
if(isset($_POST['cat-name']) && isset($_POST['action']) && $_POST['action'] == 'add-category'){
    $category   = handleField($_POST['cat-name']);
    $thumbnail  = $_FILES['thumbnail']; 
    $sql        = "SELECT * FROM category WHERE cate_name = '$category'";
    if(DB::rowCount($sql) > 0){
        $error['category'] = 'Category name already exists';
    } else {
        if($thumbnail['size'] > 0){
            if($thumbnail['error'] > 0){
                $error['thumbnail'] = 'Image file has error';
            } else if(!checkExtension($thumbnail['name'])){
                $error['thumbnail'] = 'Incorrect image format';
            } else {
                $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
                $thumbName = 'thumb-'.randomStr().'.'.$fileExtension;
            }
        } else {
            $thumbName = 'default.jpg';
        }
        if(count($error) == 0){
            $sql  = "INSERT INTO category(cate_name, cate_status) VALUES ('$category',1)";
            try{
                DB::execute($sql);
            } catch(PDOException $e){
                $error['category'] = 'Error: '. $e->getMessage();
            };
            $currentCate = DB::lastInsertID();
            if($thumbnail['size'] > 0){
                move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/category/' . $thumbName);    
            }
            try{
                DB::execute("UPDATE category SET cate_thumb = '$thumbName' WHERE cate_id = $currentCate");
            }catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
        
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['cate-name']) && isset($_POST['action']) && $_POST['action'] == 'update'){
    $category = handleField($_POST['cate-name']);
    $id       = (int)$_POST['id'];
    $thumbnail= $_FILES['thumbnail'];
    $sql      = "SELECT * FROM category WHERE cate_name = '$category' AND cate_id <> $id";
    if(DB::rowCount($sql) > 0){
        $error['category'] = 'Category name already exists';
    } else {
        if($thumbnail['size'] > 0){
            if($thumbnail['error'] > 0){
                $error['thumbnail'] = 'Image file has error';
            } else if(!checkExtension($thumbnail['name'])){
                $error['thumbnail'] = 'Incorrect image format';
            } else {
                $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
                $thumbName = 'thumb-'.randomStr().'.'.$fileExtension;
            }
        }
        if(count($error) == 0){
            $sql  = "UPDATE category SET cate_name = '$category' WHERE cate_id = $id";
            try{
                DB::execute($sql);
            }catch(PDOException $e){
                $error['category'] = $e->getMessage();
            }
            if($thumbnail['size'] > 0){
                try{
                    DB::execute("UPDATE category SET cate_thumb = '$thumbName' WHERE cate_id = $id");
                }catch(PDOException $e){
                    $error[] = $e->getMessage();
                }
                move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/category/'. $thumbName);
            }
        }
    }
    if(count($error) == 0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['category']) && isset($_POST['action']) && $_POST['action'] == 'enable'){
    $category = (int)$_POST['category'];
    try{
        $sql      = "UPDATE category SET cate_status = 1 WHERE cate_id = $category";
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
if(isset($_POST['category']) && isset($_POST['action']) && $_POST['action'] == 'disable'){
    $category = (int)$_POST['category'];
    try{
        $sql      = "UPDATE category SET cate_status = 0 WHERE cate_id = $category";
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
if(isset($_POST['category']) && isset($_POST['action']) && $_POST['action'] == 'delete'){
    $category = (int)$_POST['category'];
    try{
        $sql      = "DELETE FROM category WHERE cate_id = $category";
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
if(isset($_POST['categories']) && isset($_POST['action']) && $_POST['action'] == 'disable-all'){
    $category = $_POST['categories'];
    $listCat = array_map(function($value){
        return (int)$value;
    }, $category);
    foreach($listCat as $value){
        try{
            $sql      = "UPDATE category SET cate_status = 0 WHERE cate_id = $value";
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
if(isset($_POST['categories']) && isset($_POST['action']) && $_POST['action'] == 'enable-all'){
    $category = $_POST['categories'];
    $listCat = array_map(function($value){
        return (int)$value;
    }, $category);
    foreach($listCat as $value){
        try{
            $sql      = "UPDATE category SET cate_status = 1 WHERE cate_id = $value";
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
if(isset($_POST['get']) && $_POST['get'] == 'stats-category'){
    $sql = "SELECT category.cate_name, COUNT(cate_product.product_id) as soluongsanpham, MAX(product.product_price) as giacaonhat, MIN(product.product_price) as giathapnhat, AVG(product.product_price) as giatrungbinh FROM category, cate_product, product WHERE category.cate_id = cate_product.cate_id AND cate_product.product_id = product.product_id GROUP BY cate_product.cate_id ORDER BY cate_product.cate_id DESC;";
    $result = DB::fetchAll($sql);
    $data = array();
    foreach($result as $category){
        $data[] = array(
            'name'      => $category['cate_name'],
            'quantity'  => $category['soluongsanpham'],
            'max'       => product_price($category['giacaonhat']),
            'min'       => product_price($category['giathapnhat']),
            'avg'       => product_price($category['giatrungbinh'])
        );
    }
    echo json_encode($data);
}
?>