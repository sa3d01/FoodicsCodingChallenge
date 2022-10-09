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
    public function test_example()
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
}
