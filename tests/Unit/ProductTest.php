<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Jobs\CreateProductJob;
use App\Services\ProductService;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductTest extends TestCase
{
    /**
     * Unit test to get products
     *
     * @return void
     */
    public function test_list_all_product()
    {
        $response = $this->get(route('get-product'));
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'data', 'message'])
        );
    }
}
