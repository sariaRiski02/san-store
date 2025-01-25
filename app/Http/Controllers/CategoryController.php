<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'status' => true,
            'message' => 'Get category is successfully',
            'data' => Category::all(),
        ]);
    }
}
