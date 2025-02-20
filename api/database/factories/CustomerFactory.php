<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Configure the model factory to create customers IP addresses and company details.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Customer $customer) {
            // create ip address for customer
            $customer->ip_addresses()->create(
                [
                    'customer_id' => $customer->id,
                    'ip_address' => fake()->ipv4,
                ]
            );

            // create company for customer
            $customer->companies()->create(
                [
                    'customer_id' => $customer->id,
                    'company' => fake()->company(),
                    'city' => fake()->city(),
                    'title' => fake()->jobTitle(),
                    'website' => fake()->url(),
                ]
            );
        });
    }
 

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'gender' => fake()->randomElement(['male', 'female']),
        ];
    }
}
