<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        // Create a courier user
        User::factory()->create([
            'name' => 'Courier',
            'email' => 'courier@gmail.com',
            'password' => bcrypt('courier'),
            'role' => 'courier',
        ]);

        // Create a customer user
        $customer = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('customer'),
            'role' => 'customer',
        ]);

        // // Admin creates 10 menus
        // $menus = Menu::factory(10)->create();

        // // Customer creates 10 orders, each with 10 order items
        // Order::factory(10)->create([
        //     'user_id' => $customer->id,
        // ])->each(function ($order) use ($menus) {
        //     $order->orderItems()->saveMany(
        //         OrderItem::factory(10)->make([
        //             'menu_id' => $menus->random()->id, // Randomly assign a menu to each order item
        //         ])
        //     );
        // });
    }
}
