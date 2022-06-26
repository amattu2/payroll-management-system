<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateInterval;
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
            'period' => function (array $attributes) {
                $period = DB::table('timesheets')->where("employee_id", $attributes['employee_id'])->orderBy('period', 'desc')->first();

                if ($period) {
                  return ((clone $period->period)->add(new DateInterval("P1M")));
                } else {
                  return Employee::where("id", $attributes['employee_id'])->first()->hired_at->format("Y-m-01");
                }
            },
            'pay_type' => function (array $attributes) {
                return Employee::find($attributes['employee_id'])->pay_type;
            },
            'edit_user_id' => 1,
            'employee_id' => function (array $attributes) {
                return $attributes['employee_id'];
            },
            'completed_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween('-3 months', '+3 months')]),
        ];
    }
}
