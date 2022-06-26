<?php
/*
 * Produced: Mon Jun 20 2022
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

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class Timesheet extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      "period",
      "pay_type",
      "employee_id",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'period' => 'datetime',
    ];

    /**
     * Get the employee that this timesheet belongs to
     */
    public function Employee()
    {
      return $this->belongsTo(Employee::class);
    }

    /**
     * Get the timesheet days that belong to this timesheet
     */
    public function TimesheetDay()
    {
      return $this->hasMany(TimesheetDay::class)->orderBy("date");
    }

    /**
     * Define custom weeks attribute
     *
     * @return array<int, array>
     */
    public function getWeeksAttribute() {
      if (isset($this->attributes["weeks"])) {
        return $this->attributes["weeks"];
      }

      $start = clone $this->period;
      $end = (clone $start)->modify("last day of this month");
      $index = 0;

      for ($i = $start; $i <= $end; $i->modify('+1 day')){
        $week = $i->format("W");
        $cloned = clone $i;

        if (!isset($this->attributes["weeks"][$week])) {
          $this->attributes["weeks"][$week] = [
            "index" => $index++,
            "start" => $cloned,
            "days" => [],
            "end" => $cloned,
          ];
        }

        $this->attributes["weeks"][$week]["days"][] = $cloned;
        $this->attributes["weeks"][$week]["end"] = $cloned;
      }

      return $this->attributes["weeks"];
    }
}
