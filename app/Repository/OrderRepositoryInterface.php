<?php
namespace Amin\Arraytics\Repository;

use Request;
interface OrderRepositoryInterface{
    public function createOrder(Request $request, array $data);
    public function getOrders(Request $request);
}