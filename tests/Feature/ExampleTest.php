<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_seeder_hashes_the_account_password(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = \App\Models\User::where('email', 'admin@vestir.test')->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_catalog_filters_sale_and_novedades_queries(): void
    {
        $category = Category::create([
            'name' => 'Test category',
            'slug' => 'test-category',
            'image_url' => null,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Oferta visible',
            'description' => 'Sale product',
            'material' => 'cotton',
            'base_price' => 100,
            'old_price' => 150,
            'is_new' => false,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Nueva visible',
            'description' => 'New product',
            'material' => 'cotton',
            'base_price' => 80,
            'old_price' => null,
            'is_new' => true,
        ]);

        $saleResponse = $this->get('/catalog?sale=true');
        $saleResponse->assertOk();
        $saleResponse->assertViewHas('products', function ($products) {
            return $products->total() === 1 && $products->first()->name === 'Oferta visible';
        });

        $novedadesResponse = $this->get('/catalog?category=nueva-coleccion');
        $novedadesResponse->assertOk();
        $novedadesResponse->assertViewHas('products', function ($products) {
            return $products->total() === 1 && $products->first()->name === 'Nueva visible';
        });
    }
}
