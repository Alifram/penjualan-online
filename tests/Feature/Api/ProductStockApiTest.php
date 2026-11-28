<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductStockApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_product_stock(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin-stock@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'SKU-STOCK-001',
            'name' => 'Mouse Wireless',
            'slug' => 'mouse-wireless',
            'description' => 'Produk pengujian stok API',
            'price' => 150000,
            'stock' => 8,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson("/api/v1/admin/products/{$product->id}/stock");

        $response->assertOk()
            ->assertJsonPath('message', 'Stok produk berhasil diambil.')
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.sku', 'SKU-STOCK-001')
            ->assertJsonPath('data.name', 'Mouse Wireless')
            ->assertJsonPath('data.stock', 8);
    }

    public function test_customer_cannot_view_product_stock(): void
    {
        $customer = User::create([
            'name' => 'Pelanggan',
            'email' => 'customer-stock@example.com',
            'password' => 'password123',
            'role' => 'customer',
        ]);

        $category = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'SKU-STOCK-002',
            'name' => 'Keyboard Wireless',
            'slug' => 'keyboard-wireless',
            'description' => 'Produk pengujian akses customer',
            'price' => 200000,
            'stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson("/api/v1/admin/products/{$product->id}/stock");

        $response->assertForbidden();
    }
}
