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

use Fpdf\Fpdf;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\TimesheetDay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    "completed_at",
    "edit_user_id",
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'period' => 'datetime',
    'completed_at' => 'datetime',
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
  public function TimesheetDays()
  {
    return $this->hasMany(TimesheetDay::class)->orderBy("date");
  }

  /**
   * Get the leave requests assigned to this timesheet
   */
  public function Leaves()
  {
    return $this->hasMany(Leave::class);
  }

  /**
   * Define custom weeks attribute
   *
   * @return array<int, array>
   */
  public function getWeeksAttribute()
  {
    if (isset($this->attributes["weeks"])) {
      return $this->attributes["weeks"];
    }

    $leaves = $this->leaves->where("declined", null);
    $start = clone $this->period;
    $end = (clone $start)->modify("last day of this month");
    $index = 0;

    for ($i = $start; $i <= $end; $i->modify('+1 day')) {
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

      $this->attributes["weeks"][$week]["days"][] = [
        "day" => $this->TimesheetDays()->where("date", $cloned->format("Y-m-d"))->first() ?? new TimesheetDay([
          "date" => $cloned->format("Y-m-d"),
          "timesheet_id" => $this->id,
        ]),
        "leave" => $leaves->where("start_date", "<=", $cloned)->where("end_date", ">=", $cloned)->first(),
      ];
      $this->attributes["weeks"][$week]["end"] = $cloned;
    }

    return $this->attributes["weeks"];
  }

  /**
   * Define custom year attribute
   *
   * @return int
   */
  public function getYearAttribute()
  {
    return $this->period->format("Y");
  }

  /**
   * Define custom month attribute
   *
   * @return int
   */
  public function getMonthAttribute()
  {
    return $this->period->format("m");
  }

  /**
   * Generate a PDF of this timesheet
   *
   * @return Fpdf
   */
  public function toPDF()
  {
    $pdf = new FPDF();
    $pdf->AddPage("P", "Letter");
    $weeks = $this->weeks;
    $width = $pdf->getPageWidth() - 20;
    $total_units = 0;
    $colWidth = $width / 7;

    // PDF Options
    $pdf->AliasNbPages();
    $pdf->SetTopMargin(10);
    $pdf->SetCreator(config("app.name"));
    $pdf->SetAuthor(config("app.name"));
    $pdf->SetTitle($this->period->format("F, Y") . " Timesheet");
    $pdf->SetSubject("Timesheet export for pay period " . $this->period->format("F, Y"));
    $pdf->SetKeyWords("PDF, Confidential, Employee Timesheet, #{$this->id}");

    // Build PDF
    $pdf->SetLineWidth(0.3);
    $pdf->SetFont('Helvetica', 'B', 15);
    $pdf->Cell(0, 10, config("app.name"), 0, 0, 'L');
    $pdf->SetFont('Helvetica', '', 15);
    $pdf->Cell(0, 10, "Timesheet | " . $this->period->format("F, Y"), 0, 2, 'R');
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Ln(2);
    $pdf->SetX(10);
    $pdf->Cell($colWidth * 5, 7, "Employee: " . $this->employee->full_name . " (#" . str_pad($this->employee->id, 4, '0', STR_PAD_LEFT) . ")", 1, 0, 'L');
    $pdf->Cell($colWidth * 2, 7, "Pay Period: " . $this->period->format("F, Y"), 1, 1, 'L');
    $pdf->SetFillColor(210, 210, 210);
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell($colWidth * 0.5, 7, "Date", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 0.8, 7, "Week Day", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 2.8, 7, "Description of Work", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 0.7, 7, "Time In", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 0.7, 7, "Time Out", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 0.8, 7, "Adjustment", 1, 0, 'C', 1);
    $pdf->Cell($colWidth * 0.7, 7, "Net " . ($this->pay_type === 'hourly' ? 'Hours' : 'Days'), 1, 2, 'C', 1);
    $pdf->SetFont('Helvetica', '', 10);

    foreach ($weeks as $week) {
      foreach ($week["days"] as $day) {
        $pdf->SetX(10);
        $pdf->Cell($colWidth * 0.5, 6.9, $day["day"]->date->format("d"), 1, 0, 'R');
        $pdf->Cell($colWidth * 0.8, 6.9, $day["day"]->date->format("l"), 1, 0, 'L');
        $pdf->SetFont('Helvetica', 'I', 10);
        $pdf->Cell($colWidth * 2.8, 6.9, $day["day"]->description, 1, 0, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($colWidth * 0.7, 6.9, $day["day"]->start_time?->format("g:ia") ?? "-", 1, 0, 'C');
        $pdf->Cell($colWidth * 0.7, 6.9, $day["day"]->end_time?->format("g:ia") ?? "-", 1, 0, 'C');
        $pdf->Cell($colWidth * 0.8, 6.9, number_format($day["day"]->adjustment ?? 0, 2), 1, 0, 'C');
        $pdf->Cell($colWidth * 0.7, 6.9, number_format($day["day"]->total_units ?? 0, 2), 1, 2, 'C');
        $total_units += $day["day"]->total_units;
      }
    }

    $pdf->SetX(10);
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell($colWidth * 5.5, 7, $this->completed_at ? "Finalized on " . $this->completed_at : "", 0, 0, 'L');
    $pdf->Cell($colWidth * 1.5, 7, sprintf("Total %s: %s",
      $this->pay_type === 'hourly' ? 'Hours' : 'Days',
      number_format($total_units, 2)
    ), 1, 2, 'L', 1);

    return $pdf;
  }
}
