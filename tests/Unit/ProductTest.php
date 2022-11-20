<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Traits\ProductUtil;
use App\Jobs\CreateProductJob;
use App\Services\ProductService;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductTest extends TestCase
{
    use ProductUtil;
    protected $data;

    public function test_apply_no_discount()
    {
        $data = (object)[
            "sku"=> "000002",
            "name"=> "Ashlington leather ankle boots",
            "category"=> "sandals",
            "price"=> "7100"
        ];
        
        $response = $this->calculateProductDiscount($data->category, $data->sku, $data->price);
        $this->assertEquals(7100, $response->final_price);
    }

    public function test_apply_15_percent_discount()
    {
        $data = (object)[
            "sku"=> "000003",
            "name"=> "Ashlington leather ankle boots",
            "category"=> "sneakers",
            "price"=> "7100"
        ];
        
        $response = $this->calculateProductDiscount($data->category, $data->sku, $data->price);
        $this->assertEquals(1065, $response->final_price);
    }

    public function test_apply_30_percent_discount()
    {
        $data = (object)[
            "sku"=> "000001",
            "name"=> "Ashlington leather ankle boots",
            "category"=> "boots",
            "price"=> "7100"
        ];

        $response = $this->calculateProductDiscount($data->category, $data->sku, $data->price);
        $this->assertEquals(2130, $response->final_price);
        
    }

    public function test_apply_highest_percent_discount()
    {
        $data = (object)[
            "sku"=> "000003",
            "name"=> "Ashlington leather ankle boots",
            "category"=> "boots",
            "price"=> "7100"
        ];
        
        $response = $this->calculateProductDiscount($data->category, $data->sku, $data->price);
        $this->assertEquals(2130, $response->final_price);
    }

    public function test_list_all_product()
    {
        $response = $this->get(route('get-product'));
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'data', 'message'])
        );
    }
}
