<?php 
namespace Amin\Arraytics\Controller;
class OrderController extends BaseController{
    public function index(){
        $this->loadView('order/create');
    }
}