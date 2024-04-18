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
    private User $user;
    private User $admin;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_homepage_contains_empty_table()
    {
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
        $response->assertSee(__('No products found!'));
    }

    public function test_homepage_contains_non_empty_table()
    {
        $product = Product::factory()->create(); // Create a product

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__('No products found!'));
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        // Create 11 products
        $products = Product::factory()->count(11)->create();
        $lastProduct = $products->last();

        // Make a request as the test user
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }

    public function test_admin_can_see_products_create_button()
    {
        $response = $this->actingAs($this->admin)->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Add Product');
    }

    public function test_non_admin_cannot_see_products_create_button()
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('Add Product');
    }

    public function test_admin_can_access_create_product_page()
    {
        $response = $this->actingAs($this->admin)->get('/products/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_create_product_page()
    {
        $response = $this->actingAs($this->user)->get('/products/create');

        $response->assertStatus(403);
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create([
                'is_admin' => $isAdmin,
            ]);
    }

}
