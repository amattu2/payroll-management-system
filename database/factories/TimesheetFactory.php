<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Timesheet;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
            'period' => $this->faker->dateTimeBetween('-90 years', '+90 years'),
            'pay_type' => function (array $attributes) {
                return Employee::find($attributes['employee_id'])->pay_type;
            },
            'edit_user_id' => 1,
            'employee_id' => function (array $attributes) {
                return $attributes['employee_id'];
            },
            'completed_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween('-3 months', '+3 months')]),
            'updated_at' => null,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Timesheet $ts) {
            // Get most recent timesheet
            $lastSheet = DB::table('timesheets')
              ->where("employee_id", $ts->employee_id)
              ->where("updated_at", "!=", null)
              ->orderBy('period', 'desc')
              ->first();

            // Update timesheet period
            if ($lastSheet && $lastSheet->period) {
              $ts->period = ((new DateTime($lastSheet->period))->add(new DateInterval("P1M")))->format("Y-m-01");
            } else {
              $ts->period = Employee::where("id", $ts->employee_id)->first()->hired_at->format("Y-m-01");
            }

            // Save the new date
            $ts->save();

            // Update timesheet days
            $tsDays = DB::table("timesheet_days")
              ->where("timesheet_id", $ts->id)
              ->orderBy("id", "asc")
              ->get();

            foreach ($tsDays as $i => $tsd) {
                DB::table("timesheet_days")->where("id", $tsd->id)->update([
                    "date" => (new DateTime($ts->period))->add(new DateInterval("P{$i}D"))->format("Y-m-d"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            }
        });
    }
}
