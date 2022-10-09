<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FailedProductPlacingOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/order',[
            'products' => [
                [
                    'product_id'=>12,
                    'quantity'=>3
                ]
            ]
        ]);
        $response->assertStatus(422);
    }
}
