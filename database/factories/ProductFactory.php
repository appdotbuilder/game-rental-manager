<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Food', 'Drink', 'Snack', 'Accessory'];
        $category = fake()->randomElement($categories);
        
        $products = [
            'Food' => ['Instant Noodles', 'Fried Rice', 'Sandwich', 'Pizza Slice', 'Burger'],
            'Drink' => ['Coca Cola', 'Pepsi', 'Sprite', 'Mineral Water', 'Coffee', 'Tea'],
            'Snack' => ['Potato Chips', 'Cookies', 'Crackers', 'Popcorn', 'Candy'],
            'Accessory' => ['Gaming Headset', 'Controller', 'Charging Cable', 'Screen Cleaner'],
        ];
        
        $name = fake()->randomElement($products[$category]);
        
        $prices = [
            'Food' => [12000, 25000],
            'Drink' => [5000, 15000],
            'Snack' => [8000, 20000],
            'Accessory' => [50000, 500000],
        ];

        return [
            'name' => $name,
            'category' => $category,
            'price' => fake()->numberBetween($prices[$category][0], $prices[$category][1]),
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(85),
        ];
    }

    /**
     * Indicate that the product is active and in stock.
     */
    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'stock' => fake()->numberBetween(10, 100),
        ]);
    }
}