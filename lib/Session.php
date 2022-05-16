<?php 

class Session{
    // session start
	public static function init(){
		if(!isset($_SESSION)){
            session_start();
        }
	}

    // set value session
	public static function set($key,$val){
		$_SESSION[$key] = $val;
	}
    // get value session
	public static function get($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return false;
		}
	}
	// check isset session
	public static function issetSession($key){
		if(isset($_SESSION[$key])){
			return true;
		} else {
			return false;
		}
	}
    // check session status client
	public static function checkSessionClient(){
		if(!isset($_SESSION)) self::init();
		if(self::get('user') == false){
			self::destroy();
			header("Location: ".ROOT_URL."/home/");
		}
	}
	// check session admin
	public static function checkSessionAdmin(){
		if(!isset($_SESSION)) self::init();
		if(self::get('user') == false || self::get('user')['role'] < 2){
			self::destroy();
			header("Location: ".ROOT_URL."/admin/auth.php");
		}
	}
    // destroy session
	public static function destroy(){
		session_destroy();
	}
    // unset session
	public static function unset($key){
		unset($_SESSION[$key]);
	}

	public static function updateUser(){
		if(self::get('user')){
			$currentUser = self::get('user')['id'];
			$user = DB::fetch("SELECT * FROM users WHERE user_id = $currentUser");
			$info = [
				'id'        => $user['user_id'],
				'username'  => $user['user_name'],
				'avatar'    => $user['user_avatar'],
				'role'      => $user['user_role'],
				'email'     => $user['user_email']
			];
			self::set('user', $info);
		}
	}
}
?>