<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_homepage_contains_empty_table()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');
        $response->assertStatus(200);
        $response->assertSee(__('No products found!'));
    }

    public function test_homepage_contains_non_empty_table()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(); // Create a product
    
        $response = $this->actingAs($user)->get('/products');
    
        $response->assertStatus(200);
        $response->assertDontSee(__('No products found!'));
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        // Create a test user
        $user = User::factory()->create();
    
        // Create 11 products
        $products = Product::factory()->count(11)->create();
        $lastProduct = $products->last();
    
        // Make a request as the test user
        $response = $this->actingAs($user)->get('/products');
    
        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }

}
