<?php

namespace App\Jobs;

use App\Models\Product;
use App\Traits\ProductUtil;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class CreateProductJob implements ShouldQueue
{
    use ProductUtil, Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private const CURRENCY = 'EUR';
    protected $fetch_product, $product_query, $discount_percentage, $final_price, $price_array;
    protected $product_data;
    protected $name, $category, $sku, $price, $price_calculation;
    public function __construct(array $product_data)
    {
        $this->product_data = $product_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $discount_percentage = null;
        foreach($this->product_data as $product){
            $product = (object) $product;
            $price = $product->price;
            $category = $product->category;
            $sku = $product->sku;
            $name = $product->name;
            $price_calculation = $this->calculateProductDiscount($category, $sku, $price);
            $price_array = [
                "original" => $price,
                "final" => $price_calculation->final_price,
                "discount_percentage" => $price_calculation->discount_percentage,
                "currency" => self::CURRENCY
            ];

            Product::firstOrCreate([
                "sku" => $sku,
                "category" => $category,
                "name" => $name,
            ],[
                "price" => $price_array
            ]);
           
        }    
    }
}
