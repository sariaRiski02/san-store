<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function add(Request $request)
    {

        $data = Validator::make($request->all(), [
            "name"  => "required|string",
            "code" => "required|string",
            "quantity" => "numeric|nullable",
            "price" => "numeric|nullable"
        ]);

        if ($data->fails()) {
            return response()->json([
                "error" => $data->errors()
            ], 422);
        }

        return response()->json([
            "data" => "success"
        ], 200);
    }
}
