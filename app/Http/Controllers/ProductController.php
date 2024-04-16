<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // create
    public function create()
    {
        return view('products.create');
    }

    // store
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        // create a new product
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        // redirect to the index page
        return redirect()->route('products.index');
    }
}
