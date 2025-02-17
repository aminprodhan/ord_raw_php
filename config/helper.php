<?php
     if(!defined('ABSPATH'))
        {
            define('ABSPATH', rtrim(__DIR__, '/') . '/../');
        }
    if(!function_exists('setError')) {      
        function setError($message) {
            $_SESSION['flash_error'] = $message;
        }
    }
    if(!function_exists('hasError')) {      
        function hasError() {
            if(!isset($_SESSION['flash_error'])) return false;
            $error='<h1 class="text-danger">'.$_SESSION['flash_error'].'</h1>';
            unset($_SESSION['flash_error']);
            return $error;
        }
    }
    require_once ABSPATH.'resources/libraries/extends.php';