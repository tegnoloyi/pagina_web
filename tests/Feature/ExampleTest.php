<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutPricing;
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

    public function test_catalog_has_dedicated_novedades_and_ofertas_sections(): void
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

        $novedadesResponse = $this->get('/novedades');
        $novedadesResponse->assertOk();
        $novedadesResponse->assertViewIs('shop.novedades');
        $novedadesResponse->assertViewHas('products', function ($products) {
            return $products->total() === 1 && $products->first()->name === 'Nueva visible';
        });

        $ofertasResponse = $this->get('/ofertas');
        $ofertasResponse->assertOk();
        $ofertasResponse->assertViewIs('shop.ofertas');
        $ofertasResponse->assertViewHas('products', function ($products) {
            return $products->total() === 1 && $products->first()->name === 'Oferta visible';
        });
    }

    public function test_checkout_pricing_applies_coupon_and_loyalty_discount(): void
    {
        $customer = Customer::factory()->create([
            'email' => 'vip@scorpio.test',
            'name' => 'Cliente VIP',
        ]);

        Order::create([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'shipping_address' => 'Calle 1',
            'shipping_city' => 'Ciudad',
            'shipping_state' => 'Estado',
            'shipping_zip' => '12345',
            'payment_method' => 'tarjeta',
            'is_paid' => true,
            'status' => 'entregado',
            'subtotal' => 2200,
            'shipping' => 0,
            'total' => 2200,
        ]);

        $pricing = CheckoutPricing::calculate(1000, $customer, 'SCORPIO10', 'transferencia');

        $this->assertSame(100.0, round($pricing['discount'], 2));
        $this->assertStringContainsString('cupón', strtolower($pricing['reason']));
    }
}
