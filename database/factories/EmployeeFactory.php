<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique->safeEmail(),
            'telephone' => $this->faker->phoneNumber(),
            'street1' => $this->faker->streetAddress(),
            'street2' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->postcode(),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'hired_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'terminated_at' => $this->faker->randomElement([
              null,
              $this->faker->dateTimeBetween('-3 years', 'now')
            ]),
            'pay_type' => $this->faker->randomElement(['hourly', 'salary']),
            'pay_period' => $this->faker->randomElement(['daily', 'weekly', 'biweekly', 'monthly']),
            'pay_rate' => $this->faker->randomFloat(2, 35000, 220000),
            'title' => $this->faker->jobTitle(),
            'employment_status' => $this->faker->randomElement(['active', 'terminated', 'suspended']),
        ];
    }
}
