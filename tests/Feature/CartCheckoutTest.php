<?php

namespace Tests\Feature;

use App\Mail\OrderPlaced;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::create([
            'name' => 'Phones',
            'slug' => 'phones',
            'image' => null,
            'is_active' => true,
        ]);

        return Product::create(array_merge([
            'name' => 'iPhone 15',
            'slug' => 'iphone-15',
            'description' => 'Test product',
            'image' => null,
            'price' => 1000000,
            'stock' => 5,
            'view' => 0,
            'is_active' => true,
            'category_id' => $category->id,
        ], $overrides));
    }

    public function test_cart_adds_item_to_session(): void
    {
        $product = $this->createProduct();

        $this->from('/shop')
            ->post(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 2,
            ])
            ->assertRedirect('/shop');

        $cart = session('cart');

        $this->assertIsArray($cart);
        $this->assertEquals(2, $cart[$product->id]['quantity']);
    }

    public function test_checkout_creates_order_and_clears_cart(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $product = $this->createProduct([
            'price' => 250000,
            'stock' => 3,
        ]);

        $this->actingAs($user)
            ->withSession([
                'cart' => [
                    $product->id => ['quantity' => 2],
                ],
            ])
            ->post(route('checkout.store'), [
                'first_name' => 'An',
                'last_name' => 'Nguyen',
                'email' => 'test@example.com',
                'phone' => '0900000000',
                'address' => '123 Test Street',
                'city' => 'Ha Noi',
                'zip' => '100000',
            ])
            ->assertRedirect(route('home'));

        $order = Order::first();

        $this->assertNotNull($order);
        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals(500000, (int) $order->total_price);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 250000,
        ]);

        $this->assertEquals(1, $product->fresh()->stock);
        $this->assertFalse(session()->has('cart'));

        Mail::assertQueued(OrderPlaced::class, function (OrderPlaced $mail) use ($order) {
            return $mail->order->id === $order->id;
        });
    }
}
