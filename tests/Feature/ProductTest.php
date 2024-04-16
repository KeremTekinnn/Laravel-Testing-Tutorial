<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_homepage_contains_empty_table()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(__('No products found!'));
    }

    public function test_homepage_contains_non_empty_table()
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 9.99,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee(__('No products found!'));
    }
}
