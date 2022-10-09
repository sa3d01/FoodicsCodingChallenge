<?php

namespace App\Observers;

use App\Events\SendMail;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Support\Facades\Event;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "created" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        foreach ($orderItem->product->ingredients as $product_ingredient) {
            $ingredient_stock = Stock::where('ingredient_id', $product_ingredient->ingredient_id)->first();
            $ingredient_required = $product_ingredient->amount * $orderItem['quantity'];
            $ingredient_stock->update([
                'live_stock' => $ingredient_stock->live_stock - $ingredient_required
            ]);
            if ($ingredient_stock->notify_status == false && ($ingredient_stock->live_stock < ($ingredient_stock->base_stock / 2))) {
                Event::dispatch(new SendMail($ingredient_stock));
                $ingredient_stock->update([
                    'notify_status' => true
                ]);
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
