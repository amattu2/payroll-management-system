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

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
  use SoftDeletes, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'firstname',
    'middlename',
    'lastname',
    'email',
    'telephone',
    'street1',
    'street2',
    'city',
    'state',
    'zip',
    'birthdate',
    'hired_at',
    'terminated_at',
    'pay_type',
    'pay_period',
    'pay_rate',
    'title',
    'employment_status',
    'comments',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'comments',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'hired_at' => 'datetime',
    'terminated_at' => 'datetime',
  ];

  /**
   * Get all of the employees timesheets
   */
  public function Timesheets()
  {
    return $this->hasMany(Timesheet::class)->orderByDesc("period");
  }

  /**
   * Get all leaves associated with employee
   */
  public function Leaves()
  {
    return $this->hasMany(Leave::class)->orderByDesc("start_date");
  }

  /**
   * Get the user associated with this employee
   */
  public function User()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Define custom pending leave request attribute
   */
  public function getPendingLeavesAttribute()
  {
    return Cache::remember($this->id . 'pendingLeaves', 60 * 5, function () {
      return $this->leaves()->where("status", "pending")->get();
    });
  }

  /**
   * Define custom active pay period attribute
   */
  public function getCurrentTimesheetAttribute()
  {
    return Cache::remember($this->id . 'currentTimesheet', 60 * 5, function () {
      return $this->Timesheets()->where("period", date("Y-m-01"))->first();
    });
  }

  /**
   * Define custom timesheets by year attribute
   */
  public function getTimesheetsByYearAttribute()
  {
    return Cache::remember($this->id . 'timesheetsByYear', 60 * 1, function () {
      return $this->Timesheets->groupBy(function ($item) {
        return $item->period->format("Y");
      });
    });
  }

  /**
   * Define custom employee Full Name attribute
   */
  public function getFullNameAttribute()
  {
    return trim($this->firstname . " " . $this->lastname);
  }
}
