<?php

namespace App\Services;

use App\Events\SendMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class OrderService
{
    public function validateStock($data){
        foreach ($data['products'] as $productObj){
            $product=Product::find($productObj['product_id']);
            foreach ($product->ingredients as $product_ingredient){
                $ingredient_live_stock=Stock::where('ingredient_id',$product_ingredient->ingredient_id)->value('live_stock');
                $ingredient_required=$product_ingredient['amount']*$productObj['quantity'];
                if($ingredient_live_stock < $ingredient_required){
                    throw new HttpResponseException(response()->json([
                        'message' => 'there is no enough stock of '.$product_ingredient->ingredient->name,
                    ], 422));
                }
            }
        }
    }
    public function placingOrder($data)
    {
        DB::beginTransaction();
        $order = $this->createOrder();
        $this->createOrderItems($order->id,$data['products']);
        // UpdateLiveStock::dispatch($item);
        DB::commit();
    }
    public function createOrder(){
        return Order::create();
    }
    public function createOrderItems($orderId,$items){
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }
    public function updateStock($ingredient_stock_model,$ingredient_required){
        $ingredient_stock_model->update([
            'live_stock' => $ingredient_stock_model->live_stock - $ingredient_required
        ]);
    }
    public function sendNotifyMail($ingredient_stock){
        if (($ingredient_stock->live_stock < ($ingredient_stock->base_stock / 2))) {
            Event::dispatch(new SendMail($ingredient_stock));
            $this->updateNotifyStatus($ingredient_stock);
        }
    }
    public function updateNotifyStatus($ingredient_stock){
        $ingredient_stock->update([
            'notify_status' => true
        ]);
    }

}
