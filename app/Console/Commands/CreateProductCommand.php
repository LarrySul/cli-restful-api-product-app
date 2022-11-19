<?php

namespace App\Console\Commands;

use App\Enums\FileLocationEnum;
use Illuminate\Console\Command;
use App\Services\ProductServices;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:read-and-create-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductServices $product_service)
    {
        parent::__construct();
        $this->product_service = $product_service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->choice('Enter preferred product file path', [FileLocationEnum::CONFIG->value, FileLocationEnum::STORAGE->value], null, $maxAttempts = null, $allowMultipleSelections = false);
        switch ($path) {
            case FileLocationEnum::STORAGE->value:
                $file_path = $this->choice('Enter filename in public directory', ['Product.csv']);
                $product_data_path = public_path($file_path);
                $this->product_service->readProductDataFromCsv($product_data_path);
                $this->info('Products created sucessfully ...');
            break;
            default:
                $product_data_path = config('shopping-list')['products'];
                $this->product_service->readProductDataFromConfig($product_data_path);
                $this->info('Products created sucessfully ...');
            break;
        }

        return 0;
    }
}
