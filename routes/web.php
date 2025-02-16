<?php 
use Amin\Arraytics\Controller\OrderController;
$router=new Router();
$router->get('/', [OrderController::class, 'create']);
$router->get('/order/index', [OrderController::class, 'index']);
$router->post('/order/store', [OrderController::class, 'store']);
?>