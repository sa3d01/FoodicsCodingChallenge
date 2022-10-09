<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderPlacingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_valid_placing_order()
    {
        $response = $this->post('/api/order',[
            'products' => [
                [
                    'product_id'=>1,
                    'quantity'=>2
                ]
            ]
        ]);
        $response->assertStatus(201);
    }
    public function test_invalid_request()
    {
        $response = $this->post('/api/order');
        $response->assertStatus(422);
    }
    public function test_invalid_quantity()
    {
        $response = $this->post('/api/order',[
            'products' => [
                [
                    'product_id'=>1,
                    'quantity'=>0
                ]
            ]
        ]);
        $response->assertStatus(422);
    }
    public function test_invalid_product()
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
