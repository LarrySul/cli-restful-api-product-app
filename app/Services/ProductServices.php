<?php

namespace App\Services;

use Throwable;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use App\Jobs\CreateProductJob;
use Illuminate\Support\Facades\Bus;


class ProductServices
{
    public function __construct(){}

    public function readProductDataFromConfig($product_array)
    {
        try {
            return CreateProductJob::dispatch($product_array);
        } catch (Throwable $e) {
            info('Error occured '.json_encode($e->getMessage()));
        }
    }

    
}