<?php
/*
 * Produced: Wed Jun 22 2022
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

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Timesheet;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{
  /**
   * Get the index page
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    $employees = Cache::remember('employees', 60*5, function() {
      return DB::table('employees')->get();
    });

    return view('employees.index', ["employees" => $employees]);
  }

  /**
   * Get employee page
   *
   * @param mixed $id
   * @return \Illuminate\Contracts\View\View
   */
  public function employee($id)
  {
    $employees = Cache::remember('employees', 60*5, function() {
      return DB::table('employees')->get();
    });

    if (is_numeric($id)) {
      $employee = Employee::find($id);

      if ($employee) {
        return view('employees.employee', compact("employee", "employees"));
      }
    } else if ($id === "create") {
      return view('employees.create', compact("employees"));
    }

    return redirect()->route('employees')->withErrors(["The requested employee was not found"]);
  }

  /**
   * Create a new employee
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function create(Request $request)
  {
    $validated = request()->validate([
      'firstname' => 'required|string|max:255',
      'middlename' => 'nullable|string|max:255',
      'lastname' => 'required|string|max:255',
      'email' => 'required|string|email|max:255',
      'telephone' => 'required|string|max:255',
      'street1' => 'required|string|max:255',
      'street2' => 'nullable|string|max:255',
      'city' => 'required|string|max:255',
      'state' => 'required|string|max:2',
      'zip' => 'required|string|max:5',
      'birthdate' => 'required|date',
      'hired_at' => 'required|date',
      'pay_type' => 'required|in:hourly,salary',
      'pay_period' => 'required|in:daily,weekly,biweekly,monthly',
      'pay_rate' => 'required|numeric',
      'title' => 'required|string|max:255',
    ]);

    $employee = Employee::create($validated);

    return redirect()->route("employees.employee", $employee->id);
  }

  /**
   * Get the employee timesheet page
   *
   * @param  int $employeeId
   * @param  int|null $year
   * @param  int|null $month
   * @return \Illuminate\Contracts\View\View
   */
  public function timesheet($employeeId, $year = null, $month = null)
  {
    // Validate Input
    if (!is_numeric($employeeId)) {
      return redirect()->back()->withErrors(["The requested employee was not found"]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->route("employees.employee.timesheet", ["id" => $employeeId, "year" => date("Y"), "month" => date("m")]);
    }

    // Validate Employee
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors(["The requested employee was not found"]);
    }

    $employees = Cache::remember('employees', 60*5, function() {
      return DB::table('employees')->get();
    });

    // Get Timesheet
    $timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first()
      ?? new Timesheet(["period" => "$year-$month-01", "employee_id" => $employee->id]);

    return view('employees.timesheet', compact(
      "timesheet",
      "employee",
      "employees",
    ));
  }

  /**
   * Save updated timesheet settings
   *
   * @param  int $employeeId
   * @param  int $year
   * @param  int $month
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function saveTimesheetSettings($employeeId, $year, $month)
  {
    // Validate Input
    if (!is_numeric($employeeId) || !($employee = Employee::find($employeeId))) {
      return redirect()->back()->withErrors(["The requested employee was not found"]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->back()->withErrors(["The requested timesheet was not found"]);
    }
    if (!($timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first())) {
      return redirect()->back()->withErrors(["The requested timesheet was not found"]);
    }

    // Validate Input
    $validated = request()->validate([
      'period' => 'required|date_format:Y-m',
      'pay_type' => 'required|in:hourly,salary',
    ]);

    // Update Timesheet
    $timesheet->update($validated);

    return redirect()->route("employees.employee.timesheet", [
      "id" => $employeeId,
      "year" => $timesheet->period->format("Y"),
      "month" => $timesheet->period->format("m")
    ])->with("status", "The timesheet settings were updated");
  }

  /**
   * Get employee page
   *
   * @param int $employeeId
   * @param mixed $leaveId
   * @return \Illuminate\Contracts\View\View
   */
  public function leave($employeeId, $leaveId = null)
  {
    if (is_numeric($employeeId)) {
      $employee = Employee::find($employeeId);

      $employees = Cache::remember('employees', 60*5, function() {
        return DB::table('employees')->get();
      });

      if ($employee) {
        return view("employees.leave", compact("employee", "employees"));
      }
    }

    return redirect()->back()->withErrors(["Unable to find that leave request or employee"]);
  }

  /**
   * Update an employee's employment status
   *
   * @param  int $employeeId
   * @param  string $status active|terminated|suspended
   * @return bool
   */
  public function updateEmploymentStatus($employeeId, $status)
  {
    $employee = Employee::findOrFail($employeeId);

    $employee->employment_status = $status;
    $employee->save();

    return true;
  }
}
