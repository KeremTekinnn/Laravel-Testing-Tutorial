<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    // index
    public function index()
    {
        return Product::all();
    }

    // store
    public function store(StoreProductRequest $request)
    {
        return Product::create($request->validated());
    }
}
