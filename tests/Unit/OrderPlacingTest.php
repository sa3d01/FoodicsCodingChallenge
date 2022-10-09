<?php

namespace Tests\Unit;

use App\Services\OrderService;
use PHPUnit\Framework\TestCase;

class OrderPlacingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_invalid_stock()
    {
        $data=[
            'products' => [
                [
                    'product_id'=>1,
                    'quantity'=>2
                ]
            ]
        ];
//        $response=(new OrderService())->validateStock($data);
        $this->assertTrue((new OrderService())->validateStock($data));
    }

}
