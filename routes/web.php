<?php 
use Amin\Arraytics\Controller\OrderController;
$router=new Router();
$router->get('/', [OrderController::class, 'index']);
$router->post('/order/store', [OrderController::class, 'store']);
?>