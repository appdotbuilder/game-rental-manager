<?php

namespace Database\Factories;

use App\Models\Console;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FraudDetection>
 */
class FraudDetectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fraudTypes = [
            'unauthorized_access',
            'power_manipulation',
            'device_tampering',
            'time_manipulation',
            'payment_fraud',
        ];

        $fraudType = fake()->randomElement($fraudTypes);
        
        $descriptions = [
            'unauthorized_access' => 'Detected unauthorized physical access to console',
            'power_manipulation' => 'Console power was manipulated during rental session',
            'device_tampering' => 'Physical tampering detected on console hardware',
            'time_manipulation' => 'Suspicious time manipulation detected',
            'payment_fraud' => 'Potential payment fraud detected',
        ];

        return [
            'console_id' => Console::factory(),
            'rental_id' => fake()->boolean(70) ? Rental::factory() : null,
            'fraud_type' => $fraudType,
            'description' => $descriptions[$fraudType],
            'metadata' => [
                'sensor_data' => [
                    'accelerometer' => fake()->randomFloat(2, -10, 10),
                    'gyroscope' => fake()->randomFloat(2, -10, 10),
                    'temperature' => fake()->randomFloat(1, 25, 45),
                ],
                'network_info' => [
                    'ip_address' => fake()->ipv4(),
                    'mac_address' => fake()->macAddress(),
                ],
                'timestamp' => fake()->iso8601(),
            ],
            'severity' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'is_resolved' => fake()->boolean(30),
            'detected_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }

    /**
     * Indicate that the fraud detection is unresolved and critical.
     */
    public function critical(): static
    {
        return $this->state(fn (array $attributes) => [
            'severity' => 'critical',
            'is_resolved' => false,
            'detected_at' => fake()->dateTimeBetween('-1 day', 'now'),
        ]);
    }
}