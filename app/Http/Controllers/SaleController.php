<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function check($code_item)
    {
        $product = Product::where('code_item', $code_item)->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Get product not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get product is successfully',
            'data' => new ProductResource($product)
        ]);
    }
}
