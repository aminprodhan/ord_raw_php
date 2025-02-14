<?php 
namespace Amin\Arraytics\Controller;
class BaseController{
    public function loadView($file,$data=[]){
        include ABSPATH.'resources/views/'.$file.'.php';
    }
}
