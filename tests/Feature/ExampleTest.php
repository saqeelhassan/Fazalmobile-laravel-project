<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_product_categories_come_from_active_database_categories(): void
    {
        Category::create([
            'name' => 'Phone Cases',
            'status' => 'active',
        ]);
        Category::create([
            'name' => 'Hidden Category',
            'status' => 'inactive',
        ]);

        $categories = Product::categories();

        $this->assertContains('Phone Cases', $categories);
        $this->assertNotContains('Hidden Category', $categories);
    }

    public function test_storefront_product_routes_render_successfully(): void
    {
        Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'price' => 1000,
            'stock' => 5,
            'category' => 'Smart Watches',
            'status' => 'active',
        ]);

        $urls = [
            '/shop',
            '/shop-grid-v1',
            '/shop-grid-v2',
            '/shop-list',
            '/shop-left-sidebar',
            '/shop-right-sidebar',
            '/flash-deals',
            '/tech-discovery',
            '/trending-styles',
            '/category-fullwidth',
            '/category-left-sidebar',
            '/category-right-sidebar',
            '/search?q=Test',
            '/product/test-product',
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
    }
}
