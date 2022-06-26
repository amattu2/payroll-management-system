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
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

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
        'employment_status'
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
     * Define custom weeks attribute
     *
     * @return
     */
    public function getPendingLeavesAttribute() {
      return Cache::remember($this->id . 'pendingLeaves', 60*5, function () {
        return $this->leaves()->whereNull(["approved", "declined"])->get();
      });
    }
}
