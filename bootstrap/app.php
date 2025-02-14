<?php 
    class ApplicationBootstrap {
        private static $instance;
        private function __construct(){
            $this->defineConstants();
            $this->includeClasses();
        }
        private function defineConstants(){
            if(defined('ABSPATH')) return;
            define('ABSPATH', __DIR__.'/..//');
        }
        private function includeClasses(){
            LoadEnv::load(ABSPATH.'.env');
            require_once ABSPATH.'routes/web.php';            
        }
        public static function getInstance(){
            if(is_null(self::$instance)){
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
    function arraytics() {
		return ApplicationBootstrap::getInstance();
	}
    $GLOBALS['arraytics'] = arraytics();
?>