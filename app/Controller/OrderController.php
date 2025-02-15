<?php 
namespace Amin\Arraytics\Controller;
class OrderController extends BaseController{
    public function index(){
        $this->loadView('order/create');
    }
    public function store(\Request $request){
        $request->validate([
            'receipt_id' => 'required|text_only|max:20', //only text
            'buyer_name' => 'required|max:20|alpha_num', //text,space,number
            'buyer_email' => 'required|email',
            'city' => 'required|alpha', //text & space
            'note' => 'required|max:30',
            'entry_by' => 'required|number|max:10',
            'phone' => 'required|number|equal:13',
            'amount' => 'required|number|max:10',
            'items' => 'required|array',
        ]);
    }
}