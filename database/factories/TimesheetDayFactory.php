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

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimesheetDay>
 */
class TimesheetDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          "date" => $this->faker->dateTimeBetween('+25 years', '+190 years'),
          "description" => $this->faker->randomElement([null, "No show", "Sick", "On the road", "Traveling", $this->faker->sentence()]),
          "start_time" => $this->faker->time("H:i:s"),
          "end_time" => $this->faker->time("H:i:s"),
          "adjustment" => $this->faker->randomFloat(2, -4, 4),
          "total_units" => $this->faker->randomFloat(2, 0, 8),
          "deleted_at" => $this->faker->randomElement([null, $this->faker->dateTime("now"), null]),
          "timesheet_id" => function (array $attributes) {
              return $attributes['timesheet_id'];
          },
          "updated_at" => null,
        ];
    }
}
