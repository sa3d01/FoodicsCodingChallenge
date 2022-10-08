<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreOrderRequest;

class OrderController
{

public function store(StoreOrderRequest $request){
    return $request->validated();
}

}
