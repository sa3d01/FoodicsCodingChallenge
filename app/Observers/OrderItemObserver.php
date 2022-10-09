<?php

namespace App\Observers;

use App\Events\SendMail;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Services\OrderService;
use Illuminate\Support\Facades\Event;
use JetBrains\PhpStorm\Pure;

class OrderItemObserver
{
    protected OrderService $orderService;

    #[Pure] public function __construct()
    {
        $this->orderService = new OrderService();
    }
    /**
     * Handle the OrderItem "created" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        foreach ($orderItem->product->ingredients as $product_ingredient) {
            $ingredient_stock_model = Stock::where('ingredient_id', $product_ingredient->ingredient_id)->first();
            $ingredient_required = $product_ingredient->amount * $orderItem['quantity'];
            $this->orderService->updateStock($ingredient_stock_model,$ingredient_required);
            if ($ingredient_stock_model->notify_status == false && ($ingredient_stock_model->live_stock < ($ingredient_stock_model->base_stock / 2))) {
                $this->orderService->sendNotifyMail($ingredient_stock_model);
            }
        }
    }

    /**
     * Handle the OrderItem "updated" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function updated(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "deleted" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function deleted(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "restored" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function restored(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }
}
