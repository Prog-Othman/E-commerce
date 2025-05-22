<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if not exist
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create 10 customers
        $customers = User::factory(10)->create();
        foreach ($customers as $customer) {
            $customer->assignRole($customerRole);
        }

        // Create 5 admins
        $admins = User::factory(5)->create();
        foreach ($admins as $admin) {
            $admin->assignRole($adminRole);
        }

        // Create 5 categories
        $categories = \App\Models\Category::factory(5)->create();

        // Create 20 products, each assigned to a random category
        $products = Product::factory(20)->create([
            'category_id' => $categories->random()->id,
        ]);

        // Create 30 orders, each with 1-3 items
        $orders = Order::factory(30)->create([
            'user_id' => $customers->random()->id,
            'payment_status' => 'completed',
            'status' => 'completed',
        ]);
        foreach ($orders as $order) {
            $itemsCount = rand(1, 3);
            for ($i = 0; $i < $itemsCount; $i++) {
                $product = $products->random();
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ]);
            }
        }
    }
}
