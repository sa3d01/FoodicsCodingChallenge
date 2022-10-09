<?php

namespace App\Jobs;

use App\Events\SendMail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class UpdateLiveStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $objItem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($objItem)
    {
        $this->objItem = $objItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $item = $this->objItem;
        $product = Product::find($item['product_id']);
        foreach ($product->ingredients as $product_ingredient) {
            $ingredient_stock = Stock::where('ingredient_id', $product_ingredient->ingredient_id)->first();
            $ingredient_required = $product_ingredient->amount * $item['quantity'];
            $ingredient_stock->update([
                'live_stock' => $ingredient_stock->live_stock - $ingredient_required
            ]);
            if ($ingredient_stock->notify_status==false && ($ingredient_stock->live_stock < ($ingredient_stock->base_stock / 2)) ) {
                Event::dispatch(new SendMail($ingredient_stock));
                $ingredient_stock->update([
                    'notify_status'=>true
                ]);
            }
        }
    }
}
