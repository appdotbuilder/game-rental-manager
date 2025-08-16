<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Rental;
use App\Models\RentalPackage;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameConsoleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gamezone.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $cashier = User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@gamezone.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

        // Create consoles
        $consoles = [
            [
                'name' => 'PS5 Station #1',
                'type' => 'PS5',
                'iot_device_id' => 'PS5_001',
                'hourly_rate' => 25000,
                'status' => 'available',
                'is_online' => true,
            ],
            [
                'name' => 'PS5 Station #2',
                'type' => 'PS5',
                'iot_device_id' => 'PS5_002',
                'hourly_rate' => 25000,
                'status' => 'available',
                'is_online' => true,
            ],
            [
                'name' => 'PS4 Station #1',
                'type' => 'PS4',
                'iot_device_id' => 'PS4_001',
                'hourly_rate' => 20000,
                'status' => 'available',
                'is_online' => true,
            ],
            [
                'name' => 'PS4 Station #2',
                'type' => 'PS4',
                'iot_device_id' => 'PS4_002',
                'hourly_rate' => 20000,
                'status' => 'rented',
                'is_online' => true,
            ],
            [
                'name' => 'PS4 Station #3',
                'type' => 'PS4',
                'iot_device_id' => 'PS4_003',
                'hourly_rate' => 20000,
                'status' => 'maintenance',
                'is_online' => false,
            ],
        ];

        foreach ($consoles as $consoleData) {
            Console::create($consoleData);
        }

        // Create rental packages
        $packages = [
            [
                'name' => '1 Hour Package',
                'description' => 'Perfect for quick gaming sessions',
                'duration_hours' => 1,
                'price' => 20000,
                'is_active' => true,
            ],
            [
                'name' => '3 Hours Package',
                'description' => 'Great value for extended gaming',
                'duration_hours' => 3,
                'price' => 55000,
                'is_active' => true,
            ],
            [
                'name' => '5 Hours Package',
                'description' => 'All day gaming experience',
                'duration_hours' => 5,
                'price' => 90000,
                'is_active' => true,
            ],
            [
                'name' => 'Overnight Package',
                'description' => '10 hours of non-stop gaming',
                'duration_hours' => 10,
                'price' => 150000,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $packageData) {
            RentalPackage::create($packageData);
        }

        // Create customers
        $customers = [
            [
                'name' => 'John Doe',
                'phone' => '081234567890',
                'email' => 'john@example.com',
                'address' => 'Jl. Gaming No. 123, Jakarta',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '081234567891',
                'email' => 'jane@example.com',
                'address' => 'Jl. Console No. 456, Jakarta',
            ],
            [
                'name' => 'Bob Wilson',
                'phone' => '081234567892',
                'email' => 'bob@example.com',
                'address' => 'Jl. PlayStation No. 789, Jakarta',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        // Create products
        $products = [
            [
                'name' => 'Coca Cola',
                'category' => 'Drink',
                'price' => 8000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Pepsi',
                'category' => 'Drink',
                'price' => 8000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Mineral Water',
                'category' => 'Drink',
                'price' => 5000,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Instant Noodles',
                'category' => 'Food',
                'price' => 12000,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Potato Chips',
                'category' => 'Snack',
                'price' => 15000,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'PS5 Controller',
                'category' => 'Accessory',
                'price' => 850000,
                'stock' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Gaming Headset',
                'category' => 'Accessory',
                'price' => 300000,
                'stock' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create some sample active rentals
        $activeRental = Rental::create([
            'console_id' => 4, // PS4 Station #2
            'customer_id' => 1, // John Doe
            'rental_package_id' => 2, // 3 Hours Package
            'user_id' => $cashier->id,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHours(2),
            'total_amount' => 55000,
            'paid_amount' => 55000,
            'status' => 'active',
            'payment_status' => 'paid',
            'notes' => 'Customer wants FIFA 24',
        ]);
    }
}