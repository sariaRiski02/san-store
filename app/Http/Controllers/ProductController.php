<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code_item' => 'required|string',
            'description' => 'string|nullable',
            'category_id' => 'required|integer',
            'base_unit' => 'string|nullable',
            'quantity_base_unit' => 'nullable|integer',
            'factor_base_unit' => 'nullable|integer',
            'base_price' => 'nullable|numeric',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'discount' => 'nullable|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }


        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'code_item' => $request->input('code_item'),
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
            ]);

            $product_detail =  $product->product_detail()->create([
                'base_unit' => $request->input('base_unit'),
                'quantity_base_unit' => $request->input('quantity_base_unit'),
                'factor_base_unit' => $request->input('factor_base_unit'),
                'base_price' => $request->input('base_price'),
                'unit_price' => $request->input('unit_price'),
                'discount' => $request->input('discount')
            ]);

            $stock = $product->stock()->create([
                'quantity' => $request->input('quantity')
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully',
                'data' => [
                    'product' => $product,
                    'product_detail'  => $product_detail,
                    'stock' => $stock
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get($id)
    {
        $product = Product::with(['category', 'product_detail', 'stock'])->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        // return new ProductResource($product);
        return response()->json([
            'status' => true,
            'message' => 'Get product is successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function getAll()
    {
        return response()->json([
            'status' => true,
            'message' => "Get all product is successfully",
            'data' => ProductResource::collection(Product::all())
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code_item' => 'required|string',
            'description' => 'string|nullable',
            'category_id' => 'required|integer',
            'base_unit' => 'string|nullable',
            'quantity_base_unit' => 'nullable|integer',
            'factor_base_unit' => 'nullable|integer',
            'base_price' => 'nullable|numeric',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'discount' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Get product not found',
            ]);
        }

        try {
            $product->update([
                'name' => $request->input('name'),
                'code_item' => $request->input('code_item'),
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
            ]);

            $product->product_detail()->update([
                'base_unit' => $request->input('base_unit'),
                'factor_base_unit' => $request->input('factor_base_unit'),
                'base_price' => $request->input('base_price'),
                'unit_price' => $request->input('unit_price'),
                'discount' => $request->input('discount')
            ]);

            $product->stock()->update([
                'quantity_base_unit' => $request->input('quantity_base_unit'),
                'quantity' => $request->input('quantity')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }


        return response()->json([
            'status' => true,
            'message' => 'Updated product is successfully',
            'data' => new ProductResource($product->fresh()),
        ]);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $delete = $product->delete();

        if (!$delete) {
            return response()->json([
                'status' => false,
                'message' => "Delete product is failed"
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => "Delete product is successfully"
        ]);
    }
}
