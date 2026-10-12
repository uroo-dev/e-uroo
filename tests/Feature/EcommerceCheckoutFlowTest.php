<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceCheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_browse_home_and_products(): void
    {
        $category = Category::create([
            'name' => 'Kopi Perkebunan',
            'slug' => 'kopi-perkebunan',
            'description' => 'Biji kopi pilihan',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Kopi Gayo Arabika',
            'slug' => 'kopi-gayo-arabika',
            'sku' => 'KOP-001',
            'description' => 'Kopi segar panen PT',
            'price' => 85000,
            'stock' => 50,
            'weight' => 0.25,
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Kopi Perkebunan')
            ->assertSee('Kopi Gayo Arabika');

        $this->get('/products')
            ->assertStatus(200)
            ->assertSee('Kopi Gayo Arabika');

        $this->get('/products/'.$product->slug)
            ->assertStatus(200)
            ->assertSee('KOP-001');
    }

    public function test_guest_cannot_access_cart_or_checkout(): void
    {
        $this->get('/cart')->assertRedirect('/login');
        $this->get('/checkout')->assertRedirect('/login');
    }

    public function test_checkout_redirects_if_customer_has_no_address(): void
    {
        $user = User::factory()->create(['role' => 'pelanggan']);

        $response = $this->actingAs($user)->get('/checkout');
        $response->assertRedirect('/profile');
        $response->assertSessionHas('error');
    }

    public function test_customer_can_order_cod_and_view_digital_receipt(): void
    {
        $user = User::factory()->create(['role' => 'pelanggan']);

        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Pak Tani',
            'phone' => '081234567890',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40132',
            'full_address' => 'Jl. Kebun Percobaan No. 1',
            'is_default' => true,
        ]);

        $category = Category::create([
            'name' => 'Teh Perkebunan',
            'slug' => 'teh-perkebunan',
            'description' => 'Daun teh segar',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Teh Hitam Premium',
            'slug' => 'teh-hitam-premium',
            'sku' => 'TEH-001',
            'description' => 'Daun teh hitam pilihan',
            'price' => 50000,
            'stock' => 20,
            'weight' => 0.5,
            'is_active' => true,
        ]);

        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Process COD Checkout
        $response = $this->actingAs($user)->post('/checkout', [
            'address_id' => $address->id,
            'payment_method' => 'cod',
            'notes' => 'Tolong kirim sore hari',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cod',
            'grand_total' => 100000,
            'status' => 'pending',
        ]);

        // Stock decreased
        $this->assertEquals(18, $product->fresh()->stock);

        // Cart emptied
        $this->assertEquals(0, CartItem::where('cart_id', $cart->id)->count());

        $order = Order::where('user_id', $user->id)->first();
        $response->assertRedirect('/orders/'.$order->order_number);

        // Can view digital receipt
        $this->actingAs($user)->get('/orders/'.$order->order_number)
            ->assertStatus(200)
            ->assertSee('Struk Digital Pesanan')
            ->assertSee('Teh Hitam Premium')
            ->assertSee('COD (Bayar di Tempat)');
    }

    public function test_customer_cannot_view_other_customers_orders(): void
    {
        $user1 = User::factory()->create(['role' => 'pelanggan']);
        $user2 = User::factory()->create(['role' => 'pelanggan']);

        $order = Order::create([
            'user_id' => $user1->id,
            'order_number' => 'INV-TEST-001',
            'status' => 'pending',
            'subtotal' => 50000,
            'grand_total' => 50000,
            'payment_method' => 'cod',
        ]);

        $this->actingAs($user2)->get('/orders/'.$order->order_number)
            ->assertStatus(403);
    }
}
