<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ingredients && their stock
        $ingredientBeef=Ingredient::create([
           'name'=>'Beef'
        ]);
        Stock::create([
            'ingredient_id'=>$ingredientBeef->id,
            'base_stock'=>20000,
            'live_stock'=>20000,
        ]);
        $ingredientCheese=Ingredient::create([
           'name'=>'Cheese'
        ]);
        Stock::create([
            'ingredient_id'=>$ingredientCheese->id,
            'base_stock'=>5000,
            'live_stock'=>5000,
        ]);
        $ingredientOnion=Ingredient::create([
           'name'=>'Onion'
        ]);
        Stock::create([
            'ingredient_id'=>$ingredientOnion->id,
            'base_stock'=>1000,
            'live_stock'=>1000,
        ]);
        // products
        $product=Product::create([
            'name'=>'Burger'
        ]);
        // product ingredients
        ProductIngredient::create([
            'product_id'=>$product->id,
            'ingredient_id'=>$ingredientBeef->id,
            'amount'=>150
        ]);
        ProductIngredient::create([
            'product_id'=>$product->id,
            'ingredient_id'=>$ingredientCheese->id,
            'amount'=>30
        ]);
        ProductIngredient::create([
            'product_id'=>$product->id,
            'ingredient_id'=>$ingredientOnion->id,
            'amount'=>20
        ]);
    }
}
