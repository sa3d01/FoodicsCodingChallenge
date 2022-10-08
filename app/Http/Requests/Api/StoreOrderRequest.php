<?php

namespace App\Http\Requests\Api;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|numeric|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return [
            'products.*.product_id.exists' => "please choose valid product id ",
            'products.*.quantity.min' => "please choose valid quantity ",
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            //validate stock
            foreach ($this->products as $productObj){
                $product=Product::find($productObj['product_id']);
                foreach ($product->ingredients as $product_ingredient){
                    $ingredient_live_stock=Stock::where('ingredient_id',$product_ingredient->ingredient_id)->value('live_stock');
                    $ingredient_required=$product_ingredient['amount']*$productObj['quantity'];
                    if($ingredient_live_stock < $ingredient_required){
                        $validator->errors()->add('unavailable', 'there is no enough stock of '.$product_ingredient->ingredient->name);
                    }
                }
            }
        });
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
        ], 400));
    }

}
