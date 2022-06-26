<?php

namespace Database\Factories;

use App\Models\Timesheet;
use App\Models\TimesheetDay;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateInterval;
use DateTime;

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
          "date" => function (array $attributes) {
              $tsDay = TimesheetDay::orderBy("date", "desc")->where("timesheet_id", $attributes['timesheet_id'])->first();

              if ($tsDay) {
                return (((new DateTime($tsDay['date']))->add(new DateInterval("P1D")))->format("Y-m-d"));
              } else {
                return Timesheet::where("id", $attributes['timesheet_id'])->first()->period->format("Y-m-d");
              }
          },
          "description" => $this->faker->randomElement([null, "No show", "Sick", "On the road", "Traveling", $this->faker->sentence()]),
          "start_time" => $this->faker->time("H:i:s"),
          "end_time" => $this->faker->time("H:i:s"),
          "adjustment" => $this->faker->randomFloat(2, -4, 4),
          "total_units" => $this->faker->randomFloat(2, 0, 8),
          "deleted_at" => $this->faker->randomElement([null, $this->faker->dateTime("now"), null]),
          "timesheet_id" => function (array $attributes) {
              return $attributes['timesheet_id'];
          },
        ];
    }
}
