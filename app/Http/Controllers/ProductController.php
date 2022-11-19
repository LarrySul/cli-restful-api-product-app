<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        $paginate = $request->paginate ?? 5;
        $query = $request->filter_by;
        $price_less_than = $request->price_less_than;
        if(isset($query) && strlen($query) > 3 || isset($price_less_than)){
            $products = Product::where('category', 'like', '%' . $query . '%')
                            ->where('price->original', '<=', $price_less_than)
                            ->paginate($paginate);
        }else{
            $products = Product::paginate($paginate);
        }
       
        return response()->json([
            'data' => $products,
            'message' => 'Successful'
        ], 200);
    }
}
