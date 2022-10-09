<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreOrderRequest;
use App\Services\OrderService;

class OrderController
{
    public function __invoke(StoreOrderRequest $request, OrderService $orderService): \Illuminate\Http\JsonResponse
    {
        $orderService->placingOrder($request->validated());
        return response()->json(null, 201);
    }
}
