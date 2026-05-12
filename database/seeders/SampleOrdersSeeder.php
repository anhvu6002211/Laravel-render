<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SampleOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $targetOrders = 60;
        $existingOrders = Order::count();
        $ordersToCreate = max(0, $targetOrders - $existingOrders);

        if ($ordersToCreate === 0) {
            $this->command?->info('SampleOrdersSeeder: no new orders needed.');
            return;
        }

        $users = User::all();
        $products = Product::where('is_active', 1)->get();
        $categories = Category::with('products')->get()->filter(fn (Category $category) => $category->products->isNotEmpty());

        if ($users->isEmpty() || $products->isEmpty() || $categories->isEmpty()) {
            $this->command?->warn('SampleOrdersSeeder: missing users, products, or categories.');
            return;
        }

        $statuses = ['completed', 'processing', 'pending', 'cancelled'];
        $statusWeights = [50, 25, 20, 5];

        for ($i = 0; $i < $ordersToCreate; $i++) {
            $user = $users->random();
            $category = $categories->random();
            $categoryProducts = $category->products;

            $status = $this->pickWeighted($statuses, $statusWeights);
            $createdAt = now()
                ->subDays(rand(0, 29))
                ->setTime(rand(8, 22), rand(0, 59), rand(0, 59));

            $order = Order::create([
                'status' => $status,
                'user_id' => $user->id,
                'first_name' => 'Demo',
                'last_name' => 'Customer',
                'email' => $user->email,
                'phone' => '0900000000',
                'address' => '123 Demo Street',
                'city' => 'HCM',
                'zip' => '700000',
                'note' => 'Sample order',
                'total_price' => 0,
            ]);

            $order->created_at = $createdAt;
            $order->updated_at = $createdAt;
            $order->save();

            $itemsCount = rand(1, 4);
            $total = 0;

            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $categoryProducts->random();
                $quantity = rand(1, 3);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                $total += $quantity * (float) $product->price;
            }

            $order->total_price = $total;
            $order->save();
        }

        $this->command?->info("SampleOrdersSeeder: added {$ordersToCreate} orders.");
    }

    private function pickWeighted(array $items, array $weights): string
    {
        $total = array_sum($weights);
        $roll = rand(1, $total);
        $current = 0;

        foreach ($items as $index => $item) {
            $current += $weights[$index] ?? 0;
            if ($roll <= $current) {
                return $item;
            }
        }

        return $items[0] ?? 'pending';
    }
}
