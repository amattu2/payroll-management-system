<?php

namespace Database\Factories;

use App\Models\Employee;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

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
      $start = $this->faker->dateTimeBetween('-2 years', '+8 months');
      $approved = $this->faker->boolean;

      return [
          'employee_id' => function (array $attributes) {
              return $attributes['employee_id'];
          },
          'start_date' => $start,
          'end_date' => (clone $start)->add(new DateInterval("P".rand(1, 45)."D")),
          'comments' => $this->faker->randomElement(["", $this->faker->sentence()]),
          'approved' => $this->faker->randomElement([null, $approved ? (clone $start)->sub(new DateInterval("P".rand(1, 90)."D")) : null]),
          'approved_user_id' => null,
          'declined' => $this->faker->randomElement([null, !$approved ? (clone $start)->sub(new DateInterval("P".rand(1, 90)."D")) : null]),
          'declined_user_id' => null,
          'timesheet_id' => null,
          'type' => $this->faker->randomElement(['paid', 'sick', 'vacation', 'parental', 'unpaid', 'other']),
          'created_at' => (clone $start)->sub(new DateInterval("P".mt_rand(1, 90)."D")),
          'updated_at' => null,
      ];
    }
}
