<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'period' => $this->faker->dateTimeBetween('-3 years', '+3 months')->format("Y-m-") . "01",
            'pay_type' => $this->faker->randomElement(['hourly', 'salary']),
            'edit_user_id' => 1,
            'employee_id' => Employee::factory(),
            'completed_at' => $this->faker->randomElement([
                null,
                $this->faker->dateTimeBetween('-3 years', '+3 months')
            ]),
        ];
    }
}
