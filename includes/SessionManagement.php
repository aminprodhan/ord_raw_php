<?php
class SessionManagement{
    public static $user_request_data = null;
    public function __construct(){
        session_start();
    }
    public static function setUserRequestSession($value){
        $_SESSION[self::$user_request_data] = $value;
    }
    public static function request(){
        return $_SESSION[self::$user_request_data];
    }
}