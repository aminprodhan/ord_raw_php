<?php 
    class ApplicationBootstrap {
        private static $instance;
        private function __construct(){
            $this->includeClasses();
        }
        private function includeClasses(){
            LoadEnv::load(ABSPATH.'.env');
            date_default_timezone_set(getenv('APP_TIMEZONE'));
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