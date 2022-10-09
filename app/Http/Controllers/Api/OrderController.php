<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreOrderRequest;
use App\Jobs\UpdateLiveStock;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController
{
    public function __invoke(StoreOrderRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        $order = Order::create();
        foreach ($request['products'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
//            UpdateLiveStock::dispatch($item);
        }
        DB::commit();
        return response()->json(['status' => 'ok'], 201);
    }
}
