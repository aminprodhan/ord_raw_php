<?php 
use Amin\Arraytics\Controller\OrderController;
$router=new Router();
$router->get('/', [OrderController::class, 'index']);

?>