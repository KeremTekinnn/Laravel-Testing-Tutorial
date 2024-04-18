<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = Product::paginate(10);

        return view('products.index', ['products' => $products]);
    }

    // create
    public function create()
    {
        return view('products.create');
    }

    // store
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        // redirect to the index page
        return redirect()->route('products.index');
    }

    // edit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // update
    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        // redirect to the index page
        return redirect()->route('products.index');
    }
}
