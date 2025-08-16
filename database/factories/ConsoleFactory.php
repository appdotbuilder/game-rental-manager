<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Console>
 */
class ConsoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['PS4', 'PS5'];
        $type = fake()->randomElement($types);
        
        return [
            'name' => $type . ' Station #' . fake()->numberBetween(1, 20),
            'type' => $type,
            'iot_device_id' => strtoupper($type) . '_' . fake()->unique()->numerify('###'),
            'hourly_rate' => $type === 'PS5' ? 25000 : 20000,
            'status' => fake()->randomElement(['available', 'rented', 'maintenance']),
            'is_online' => fake()->boolean(80), // 80% chance of being online
        ];
    }

    /**
     * Indicate that the console is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
            'is_online' => true,
        ]);
    }

    /**
     * Indicate that the console is rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rented',
            'is_online' => true,
        ]);
    }
}