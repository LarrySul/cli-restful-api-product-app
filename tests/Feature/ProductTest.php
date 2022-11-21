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

    public function test_verify_cli_command_and_dispatch_queue()
    {
        $this->artisan('command:read-and-create-product')
                ->expectsQuestion('Enter preferred product file path', FileLocationEnum::CONFIG->value)
                ->assertSuccessful();
                
        Queue::fake();
        CreateProductJob::dispatch(config('shopping-list')['products']);
        Queue::assertPushed(CreateProductJob::class);
    }

}
