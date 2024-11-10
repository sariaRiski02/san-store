<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function add(Request $request)
    {

        $data = Validator::make($request->all(), [
            "name"  => "required|string",
            "code" => "required|string",
            "price" => "required|numeric",
            "quantity" => "numeric|nullable",
        ]);

        if ($data->fails()) {
            return response()->json([
                "status" => "error",
                "error" => $data->errors()
            ], 422);
        }
        $product = Product::create($data->validated());
        return response()->json([
            "status" => "success",
            "data" => $product
        ], 200);
    }


    public function getAll()
    {
        return Product::all();
    }


    public function getById($id)
    {
        return Product::find($id);
    }

    public function update($id, Request $request)
    {

        try {
            $product = Product::updateOrCreate(
                ['id' => $id],
                $request->only(['name', 'code', 'price', 'quantity'])
            );

            return response()->json([
                "status" => "success",
                "data" => $product
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                "status" => "error",
                "data" => $th
            ]);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "status" => "error",
                "message" => "Product not found"
            ], 404);
        }

        $product->delete();

        return response()->json([
            "status" => "success",
            "message" => "Product deleted successfully"
        ], 200);
    }
}
