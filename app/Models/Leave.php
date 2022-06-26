<?php

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
        "approved",
        "approved_user_id",
        "declined",
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
        'approved' => 'datetime',
        'declined' => 'datetime',
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
}
