<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class CreateProductJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private const CURRENCY = 'EUR';
    private $fetch_product, $product_query, $discount_percentage, $final_price, $price_array;
    private $product_data;
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
            $price = $this->convertPriceToInt($product->price);
            if(trim(strtolower($product->category)) == 'boots' || 
                    $product->category == 'boots' && $product->sku == '000003'){
                $final_price = 0.3 * $price;
                $discount_percentage = '30%';
            }else if($product->sku == '000003' ){
                $final_price = 0.15 * $price;
                $discount_percentage = '15%';
            }else{
                $final_price = $price;
            }

            $price_array = [
                "original" => $price,
                "final" => $final_price,
                "discount_percentage" => $discount_percentage,
                "currency" => self::CURRENCY
            ];

            Product::firstOrCreate([
                "sku" => $product->sku,
                "category" => $product->category,
                "name" => $product->name,
            ],[
                "price" => $price_array
            ]);
           
        }    
    }

    private function convertPriceToInt(string $price) :int
    {   
        $price = is_int($price) ? ($price) : intval($price);
        return  $price * 100;
    }
}
