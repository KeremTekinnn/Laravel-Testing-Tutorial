<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // index
    public function index()
    {
        return Product::all();
    }

    // store
    public function store(Request $request)
    {
        return Product::create($request->validated());
    }
}
