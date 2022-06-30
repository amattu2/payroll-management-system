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

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "comments",
        "start_date",
        "end_date",
        "status",
        "approved_at",
        "approved_user_id",
        "declined_at",
        "declined_user_id",
        "employee_id",
        "timesheet_id",
        "type",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
        'declined_at' => 'datetime',
    ];

    /**
     * Get employee that this leave belongs to
     */
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get timesheet that this leave may be associated with
     */
    public function Timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }

    /**
     * Get the duration of this leave
     *
     * @return \DateInterval duration
     */
    public function getDurationAttribute()
    {
        return $this->start_date->diff($this->end_date);
    }
}
