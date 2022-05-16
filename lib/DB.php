<?php
class DB{
    private static $_hostname = 'localhost';
    private static $_username = 'root';
    private static $_password = '';
    private static $_dbname   = 'duan1_csdl';
    private static $_conn;
    private static $_instance;
    public static function init(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    private function __construct(){
        self::$_conn = new PDO("mysql:host=".self::$_hostname.";dbname=".self::$_dbname.";charset=utf8", self::$_username, self::$_password);
        self::$_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$_conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    private function __clone(){

    }
    // lấy tất cả bản ghi
    public static function fetchAll($sql){
        $stmt = self::$_conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // lấy 1 bản ghi
    public static function fetch($sql){
        $stmt = self::$_conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    // đếm số bản ghi
    public static function rowCount($sql){
        $stmt = self::$_conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    // thực hiện câu lênh, trả về
    public static function execute($sql){
        $stmt = self::$_conn->prepare($sql);
        $stmt->execute();
    }
    // kiểm tra sự tồn tại của bản ghi, trả về true hoặc false
    public static function issetRecord($sql){
        if(self::rowCount($sql) > 0) return true;
        return false;
    }
    // lấy bản ghi cuối 
    public static function lastInsertID(){
        return self::$_conn->lastInsertId();
    }
    public static function getSettings(){
        $sql = "SELECT * FROM web_settings";
        return self::fetch($sql);
    }
    public static function checkExist($col, $table, $x) {
        $sql = "SELECT $col FROM $table";
        $arrayCol = self::fetchAll($sql);
        if (in_array($x, $arrayCol)) return true;
        else return false;
    }
    
}
