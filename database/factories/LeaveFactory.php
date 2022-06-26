<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
      return [
          'employee_id' => Employee::factory(),
          'start_date' => $this->faker->dateTimeBetween('-3 years', 'now'),
          'end_date' => $this->faker->dateTimeBetween('-3 years', 'now'),
          'comments' => $this->faker->sentence(),
          'approved' => $this->faker->randomElement([
            null,
            $this->faker->dateTimeBetween('-3 years', 'now')
          ]),
          'approved_user_id' => null,
          'declined' => $this->faker->randomElement([
            null,
            $this->faker->dateTimeBetween('-3 years', 'now')
          ]),
          'declined_user_id' => null,
          'timesheet_id' => null,
          'type' => $this->faker->randomElement(['paid', 'sick', 'vacation', 'parental', 'unpaid', 'other']),
      ];
    }
}
