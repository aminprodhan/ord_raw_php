<?php 
namespace Amin\Arraytics\Controller;
class BaseController{
    public function loadView($file,$data=[]){
        include_once ABSPATH.'resources/views/'.$file.'.php';
    }
}
