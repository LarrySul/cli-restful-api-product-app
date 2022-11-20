<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Enums\FileLocationEnum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A console test for command I/O flow of large data.
     *
     * @return void
     */

    public function test_read_and_create_product()
    {
        $this->artisan('command:read-and-create-product')
                ->expectsQuestion('Enter preferred product file path', FileLocationEnum::STORAGE->value)
                ->expectsQuestion('Enter filename in public directory', 'Product.csv')
                ->assertSuccessful();
    }
}
