<?php
/*
 * Produced: Wed Jun 29 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Database\Factories;

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
      $status = $this->faker->randomElement(['approved', 'pending', 'declined']);
      $created = (clone $start)->sub(new DateInterval("P".mt_rand(2, 90)."D"));

      return [
          'employee_id' => function (array $attributes) {
              return $attributes['employee_id'];
          },
          'start_date' => $start,
          'end_date' => (clone $start)->add(new DateInterval("P".rand(1, 45)."D")),
          'comments' => $this->faker->randomElement(["", $this->faker->sentence()]),
          'status' => $status,
          'approved_at' => $status === "approved" ? $this->faker->dateTimeBetween($created, $start) : null,
          'approved_user_id' => null,
          'declined_at' => $status === "declined" ? $this->faker->dateTimeBetween($created, $start) : null,
          'declined_user_id' => null,
          'timesheet_id' => null,
          'type' => $this->faker->randomElement(['paid', 'sick', 'vacation', 'parental', 'unpaid', 'other']),
          'created_at' => $created,
          'updated_at' => null,
      ];
    }
}
