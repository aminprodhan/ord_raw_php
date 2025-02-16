<?php
namespace Amin\Arraytics\Repository;
use Amin\Arraytics\Models\Order;
class OrderRepository implements OrderRepositoryInterface{
    private $orderModel;
    public function __construct(){
        $this->orderModel=new Order();
    }
    public function createOrder(\Request $request,array $data){
       
        if (isset($_COOKIE['order_submission_lock'])) {
            $response = [
                "status" => "error",
                "message" => "You have already submitted. Please try again after 24 hours."
            ];
            return \JsonResponse::send(409, $response);
        }

       $calculateTotal=0;
       foreach($data['items'] as $index => $item){
           $calculateTotal+=$data['qty'][$index]*$data['rate'][$index];
        }
        if($calculateTotal!=$data['amount']){
            return \JsonResponse::error('Invalid Amount', 400);
        }
        try{
            $items=implode(',', $data['items']);
            $salt = bin2hex(random_bytes(16));
            $salt_data = $data['receipt_id'] . $salt;        
            $hash_key = hash("sha512", $salt_data);
            $info=[
                'amount'=>$data['amount'],
                'receipt_id'=>$data['receipt_id'],
                'buyer'=>$data['buyer_name'],
                'buyer_email'=>$data['buyer_email'],
                'buyer_ip'=>$request->getVisitorIP(),
                'city'=>$data['city'],
                'phone'=>$data['phone'],
                'note'=>$data['note'],
                'entry_by'=>$data['entry_by'],
                'items'=> $items,
                'hash_key' => $hash_key,
            ];
            $lastId=$this->orderModel->create($info);
            \JsonResponse::sendWithCookie(200, [
                "data" => [
                    "status" => "success",
                    "message" => "Order submitted successfully."
                ],
                "cookie_name" => "order_submission_lock",
                "cookie_value" => $lastId,
                "cookie_expire" => time() + 86400,
                "cookie_path" => "/",
                "cookie_domain" => "",
                "cookie_secure" => false,
                "cookie_httponly" => true
            ]);
        }
        catch(\Exception $e){
            setcookie("order_submission_lock", "", time() - 3600, "/");
            return \JsonResponse::error($e->getMessage(), 400);
        } 
    }
    public function getOrders(){
        setcookie("order_submission_lock", "", time() - 3600, "/");
        echo 1;
    }
}