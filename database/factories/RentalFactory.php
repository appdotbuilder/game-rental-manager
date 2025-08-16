<?php

namespace Database\Factories;

use App\Models\Console;
use App\Models\Customer;
use App\Models\RentalPackage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('-1 month', 'now');
        $duration = fake()->numberBetween(1, 8);
        $endTime = (clone $startTime)->modify("+{$duration} hours");
        $totalAmount = $duration * fake()->numberBetween(15000, 25000);
        $paidAmount = fake()->randomFloat(2, 0, $totalAmount);
        
        $paymentStatus = 'pending';
        if ($paidAmount >= $totalAmount) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'partial';
        }

        return [
            'console_id' => Console::factory(),
            'customer_id' => Customer::factory(),
            'rental_package_id' => fake()->boolean(70) ? RentalPackage::factory() : null,
            'user_id' => User::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'actual_end_time' => fake()->boolean(30) ? $endTime : null,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'status' => fake()->randomElement(['active', 'completed', 'cancelled']),
            'payment_status' => $paymentStatus,
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Indicate that the rental is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'actual_end_time' => null,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
        ]);
    }

    /**
     * Indicate that the rental is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'actual_end_time' => fake()->dateTimeBetween($attributes['start_time'], 'now'),
        ]);
    }
}