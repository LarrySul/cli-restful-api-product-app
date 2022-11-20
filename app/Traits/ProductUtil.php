<?php

namespace App\Traits;


trait ProductUtil
{   
	protected $final;
	protected $discount_percentage;

	protected function calculateProductDiscount(string $category, string $sku, int $price) : object
	{	
		$discount_percentage = null;
		if($category == 'boots' || $category == 'boots' && $sku == '000003'){
			$final_price = 0.3 * $price;
			$discount_percentage = '30%';
		}else if($sku == '000003'){
			$final_price = 0.15 * $price;
            $discount_percentage = '15%';
		}else{
			$final_price = $price;
		}

		return (object)['final_price' => $final_price, 'discount_percentage' => $discount_percentage];
	}
}