<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RentalPackage>
 */
class RentalPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $duration = fake()->randomElement([1, 2, 3, 4, 5, 8, 10, 12]);
        $basePrice = 20000;
        $discount = $duration > 3 ? 0.1 : 0; // 10% discount for longer packages
        
        return [
            'name' => $duration . ' Hour' . ($duration > 1 ? 's' : '') . ' Package',
            'description' => fake()->sentence(),
            'duration_hours' => $duration,
            'price' => ($basePrice * $duration) * (1 - $discount),
            'is_active' => fake()->boolean(85), // 85% chance of being active
        ];
    }

    /**
     * Indicate that the package is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}