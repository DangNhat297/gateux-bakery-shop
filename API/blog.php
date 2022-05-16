<?php
require_once 'require.php';
$error  = [];
$status = 'error';
$date       = new DateTime();
$createdAt   = $date->format("Y-m-d H:i:s");
if(isset($_POST['get']) && $_POST['get'] == 'list-post'){
    $listPost = DB::fetchAll("SELECT * FROM blog");
    echo json_encode($listPost);
}
if(isset($_POST['get']) && $_POST['get'] == 'post'){
    $id = (int)$_POST['id'];
    $post = DB::fetch("SELECT * FROM blog WHERE blog_id = $id");
    $categories = DB::fetchAll("SELECT cate_id FROM cate_blog WHERE blog_id = $id");
    $dataCat = [];
    foreach($categories as $cat){
        $dataCat[] = $cat['cate_id'];
    }
    $data = [
        'id'            => $post['blog_id'],
        'title'         => $post['blog_title'],
        'thumb'         => $post['blog_thumbnail'],
        'shortdesc'     => $post['blog_excerpt'],
        'slug'          => $post['blog_slug'],
        'content'   => $post['blog_content'],
        'categories'    => $dataCat
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'add-post'){
    $user           = Session::get('user')['username'];
    $title          = htmlspecialchars(trim($_POST['title']));
    $title          = ucwords(strtolower($title));
    $slug           = handleField($_POST['slug']);
    $shortDesc      = handleField($_POST['short-description']);
    $content        = $_POST['content'];
    $categories     = $_POST['categories'];
    $thumbnail      = $_FILES['thumbnail'];
    if(!checkLength($title, 5, 10000)){
        $error['title'] = 'Minimum length of product name is 5';
    }
    if($thumbnail['error'] > 0){
        $error['thumbnail'] = 'Image file has error';
    } else if(!checkExtension($thumbnail['name'])){
        $error['thumbnail'] = 'Incorrect image format';
    }
    if(DB::rowCount("SELECT * FROM blog WHERE blog_slug = '$slug'") > 0){
        $slug .= '-1';
    }
    if(count($error) == 0){
        $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
        $thumbName = 'post-'.randomStr().'.'.$fileExtension;
        $sql = "INSERT INTO blog VALUES(null, '$title', '$shortDesc', '$thumbName', '$content', '$createdAt', '$user', '$slug', 0)";
        try{
            DB::execute($sql);
        } catch(PDOException $e){
            $error[] = $e->getMessage();
        }
        $currentPost = DB::lastInsertID();
        foreach($categories as $value){
            $sql = "INSERT INTO cate_blog VALUES ($currentPost, $value)";
            try{
                DB::execute($sql);
            } catch(PDOException $e){
                $error[] = $e->getMessage();
            }
        }
    }
    if(count($error) == 0){
        move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/post/' . $thumbName);
        $status = 'success';
    }
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'update-post'){
    $id             = (int)$_POST['id'];
    $user           = Session::get('user')['username'];
    $title          = htmlspecialchars(trim($_POST['title']));
    $title          = ucwords(strtolower($title));
    $slug           = handleField($_POST['slug']);
    $shortDesc      = handleField($_POST['short-description']);
    $content        = $_POST['content'];
    $categories     = $_POST['categories'];
    $thumbnail      = $_FILES['thumbnail'];
    if(!checkLength($title, 5, 10000)){
        $error['title'] = 'Minimum length of product name is 5';
    }
    if(DB::rowCount("SELECT * FROM blog WHERE blog_slug = '$slug' AND blog_id <> $id") > 0){
        $slug .= '-1';
    }
    if(count($error) == 0){
        $sql = "UPDATE blog SET blog_title = '$title', blog_excerpt = '$shortDesc', blog_content = '$content', blog_slug = '$slug' WHERE blog_id = $id";
        try{
            DB::execute($sql);
        } catch(PDOException $e){
            $error[] = $e->getMessage();
        }
        try{
            DB::execute("DELETE FROM cate_blog WHERE blog_id = $id");
        } catch(PDOException $e){
            $error['delete'] = $e->getMessage();
        }
        foreach($categories as $value){
            try{
                DB::execute("INSERT INTO cate_blog VALUES ($id, $value)");
            } catch(PDOException $e){
                $error['cat'] = $e->getMessage();
            }
        }
        if($thumbnail['size'] > 0){
            if($thumbnail['error'] > 0){
                $error['thumbnail'] = 'Image file has error';
            } else if(!checkExtension($thumbnail['name'])){
                $error['thumbnail'] = 'Incorrect image format';
            } else {
                $fileExtension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
                $thumbName = 'thumb-'.randomStr().'.'.$fileExtension;
                try{
                    DB::execute("UPDATE blog SET blog_thumbnail = '$thumbName' WHERE blog_id = $id");
                }catch(PDOException $e){
                    $error[] = $e->getMessage();
                }
                if(count($error) == 0){
                    move_uploaded_file($thumbnail['tmp_name'], '../assets/uploads/post/' . $thumbName);
                }
            }
        }
    }
    if(count($error) == 0){
        $status = 'success';
    }
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
if(isset($_POST['action']) && $_POST['action'] == 'delete-post'){
    $id = (int)$_POST['id'];
    $sql = "DELETE FROM blog WHERE blog_id = $id";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
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