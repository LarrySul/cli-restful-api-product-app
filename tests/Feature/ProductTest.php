<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\CreateProductJob;
use App\Enums\FileLocationEnum;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A console test for command I/O flow of large data.
     *
     * @return void
     */

    public function test_input_output_command_is_successful()
    {
        $this->artisan('command:read-and-create-product')
                ->expectsQuestion('Enter preferred product file path', FileLocationEnum::CONFIG->value)
                ->assertSuccessful();
    }

    public function test_create_product_job_is_pushed_to_queue()
    {
        Queue::fake();
        CreateProductJob::dispatch(config('shopping-list')['products']);
        Queue::assertPushed(CreateProductJob::class);
    }
}
