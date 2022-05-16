<?php
require_once 'require.php';
$error = array();
$status = 'error';
if(isset($_POST['get']) && $_POST['get'] == 'chat-home'){
    $xhtml = '';
    $list = DB::fetchAll("SELECT chat_home.*, users.user_name, users.user_avatar FROM chat_home, users WHERE chat_home.user_id = users.user_id ORDER BY chat_home.id ASC");
    $data = [];
    $user = Session::get('user')['username'];
    foreach($list as $chat){
        $data[] = [
            'username'      => $chat['user_name'],
            'avatar'        => $chat['user_avatar'],
            'content'       => $chat['content'],
            'time'          => showTime($chat['created_at'])
        ];
    }
    foreach($data as $val){
        if($val['username'] == $user){
            $xhtml .= '<!--begin::Message Out-->
                        <div class="d-flex flex-column mb-5 align-items-end">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text-muted font-size-sm">'.$val['time'].'</span>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$val['username'].'</a>
                                </div>
                                <div class="symbol symbol-circle symbol-35 ml-3">
                                    <img alt="Pic" src="../assets/uploads/avatar/'.$val['avatar'].'">
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">'.$val['content'].'</div>
                        </div>
                        <!--end::Message Out-->';
        } else {
            $xhtml .= '<!--begin::Message In-->
                        <div class="d-flex flex-column mb-5 align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-35 mr-3">
                                    <img alt="Pic" src="../assets/uploads/avatar/'.$val['avatar'].'">
                                </div>
                                <div>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$val['username'].'</a>
                                    <span class="text-muted font-size-sm">'.$val['time'].'</span>
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">'.$val['content'].'</div>
                        </div>
                        <!--end::Message In-->';
        }
    }
    echo $xhtml;
}
if(isset($_POST['action']) && $_POST['action'] == 'add-chat'){
    $wordError = "fuck|cunt|lol|loz|dcm|dm|cc|dkm|clmm|cmm|\'|\"";
    $currentTime = date("Y-m-d H:i:s");
    $message = htmlspecialchars(trim($_POST['message']));
    $message = preg_replace("#($wordError)#i", "***", $message);
    $userID = Session::get('user')['id'];
    $sql = "INSERT INTO chat_home(content,created_at,user_id) VALUES('$message', '$currentTime', $userID)";
    try{
        DB::execute($sql);
    }catch(PDOException $e){
        $error[] = $e->getMessage();
    }
    if(count($error)==0) $status = 'success';
    $data = [
        'status'    => $status,
        'message'   => $error
    ];
    echo json_encode($data);
}
?>