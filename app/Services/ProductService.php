<?php

namespace App\Services;

use Throwable;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use App\Jobs\CreateProductJob;
use Illuminate\Support\Facades\Bus;

class ProductService
{
    public function __construct(){}

    public function readProductDataFromConfig(array $product_array)
    {
        try {
            return CreateProductJob::dispatch($product_array);
        } catch (Throwable $e) {
            info('Error occured '.json_encode($e->getMessage()));
        }
    }

    public function readProductDataFromCsv(string $product_data_path)
    {
        try {
            $product_array = [];
            if (($open = fopen($product_data_path, "r")) !== FALSE) 
            {
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                {       
                    $data = [
                            'sku' => $data[0],
                            'name' => $data[1],
                            'category' => $data[2],
                            'price' => $data[3]
                    ]; 

                    $product_array[] = $data; 
                }
                fclose($open);
            }
            array_shift($product_array);
            
            $row_chunk = array_chunk($product_array, 500);
            $chunk_product_data = array_map(function($row_chunk, $keys){
                return new CreateProductJob($row_chunk);
              }, $row_chunk, array_keys($row_chunk));

            $batch = Bus::batch($chunk_product_data)->then(function (Batch $batch) {
                info('all jobs completed successfully...');
            })->catch(function (Batch $batch, Throwable $e) {
                info('first batch job failure detected...'. json_encode($e->getMessage()));
            })->finally(function (Batch $batch) {
                info('batch executed successful');
            })->dispatch();

        } catch (Throwable $e) {
            info('Error occured '.json_encode($e->getMessage()));
        }
    }
}