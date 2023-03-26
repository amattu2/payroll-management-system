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

use App\Mail\CustomMail;
use App\Models\Employee;
use App\Models\Timesheet;
use App\Models\TimesheetDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\LeaveApproved;
use App\Notifications\LeaveDeclined;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Notifications\TimesheetFinalized;

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
    $top = Cache::remember('topEmployees', 60 * 5, function () {
      return DB::table('employees')
        ->select('id', 'firstname', 'lastname', 'title')
        ->where('employment_status', 'active')
        ->orderBy('hired_at', 'desc')
        ->limit(4)
        ->get();
    });

    return view('employees.index', compact('top'));
  }

  /**
   * Get employee page
   *
   * @param mixed $id
   * @return \Illuminate\Contracts\View\View
   */
  public function employee($id)
  {
    if (is_numeric($id)) {
      $employee = Employee::find($id);

      if ($employee) {
        return view('employees.employee', compact("employee"));
      }
    } else if ($id === "create") {
      return view('employees.create');
    }

    return redirect()->route('employees')->withErrors([__("messages.404.employee")]);
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
      'comments' => 'nullable|string',
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
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->route("employee.timesheet", ["id" => $employeeId, "year" => date("Y"), "month" => date("m")]);
    }

    // Validate Employee
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    // Get Timesheet
    $timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first() ?? new Timesheet([
      "period" => "$year-$month-01",
      "pay_type" => $employee->pay_type,
      "employee_id" => $employee->id,
    ]);

    return view('employees.timesheet', compact("timesheet", "employee"));
  }

  /**
   * Save updated timesheet settings
   *
   * @param  int $employeeId
   * @param  int $year
   * @param  int $month
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function updateTimesheetSettings($employeeId, $year, $month)
  {
    // Validate Input
    if (!is_numeric($employeeId) || !($employee = Employee::find($employeeId))) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }
    if (!($timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first())) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }

    // Validate Input
    $validated = request()->validate([
      'period' => 'required|date_format:Y-m',
      'pay_type' => 'required|in:hourly,salary',
    ]);
    if (request()->has("completed_at")) {
      $validated["completed_at"] = $timesheet->completed_at ?? Carbon::now();
    } else {
      $validated["completed_at"] = null;
    }

    // Update Timesheet
    $timesheet->update($validated);

    if ($timesheet->completed_at && $timesheet->wasChanged("completed_at")) {
      $employee->notify(new TimesheetFinalized($timesheet));
    }

    return redirect()->route("employee.timesheet", [
      "id" => $employeeId,
      "year" => $timesheet->period->format("Y"),
      "month" => $timesheet->period->format("m"),
    ])->with("status", "The timesheet settings were updated");
  }

  /**
   * Save updated timesheet days
   *
   * @param  int $employeeId
   * @param  int $year
   * @param  int $month
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function updateTimesheet($employeeId, $year, $month)
  {
    // Validate Input
    if (!is_numeric($employeeId) || !($employee = Employee::find($employeeId))) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }

    $validated = request()->validate([
      'days' => 'required|array',
      'days.*.id' => 'nullable|exists:timesheet_days,id',
      'days.*.description' => 'nullable|string',
      'days.*.start_time' => 'nullable|date_format:H:i|before:days.*.end_time',
      'days.*.end_time' => 'nullable|date_format:H:i|after:days.*.start_time',
      'days.*.adjustment' => 'nullable|numeric',
      'days.*.total_units' => 'numeric',
    ]);

    $timesheet = $employee->timesheets()->updateOrCreate(["period" => "$year-$month-01", "completed_at" => null], [
      "period" => "$year-$month-01",
      "employee_id" => $employee->id,
      "completed_at" => request()->get("submit") === "complete" ? Carbon::now() : null,
      "edit_user_id" => auth()->id(),
    ]);

    if ($timesheet->wasRecentlyCreated) {
      $timesheet->update(["pay_type" => $employee->pay_type]);
    }

    $days = $timesheet->TimesheetDays();
    foreach ($validated["days"] as $date => $day) {
      $day['date'] = $date;
      $day['adjustment'] = isset($day['adjustment']) && $day['adjustment'] % 15 === 0 ? $day['adjustment'] : 0;
      $day['total_units'] = $day['total_units'] ?? 0;
      if (!$day['start_time'] && !$day['end_time'] && empty($day['description'])) {
        TimesheetDay::find($day['id'])?->delete();
      } else if (is_numeric($day['id'])) {
        TimesheetDay::find($day['id'])->update($day);
      } else {
        $days->create($day);
      }
    }

    if ($timesheet->completed_at && $timesheet->wasChanged("completed_at")) {
      $employee->notify(new TimesheetFinalized($timesheet));
    }

    return redirect()->route("employee.timesheet", [
      "id" => $employeeId,
      "year" => $timesheet->period->format("Y"),
      "month" => $timesheet->period->format("m"),
    ])->with("status", "The timesheet was updated successfully");
  }

  /**
   * Get employee leaves page
   *
   * @param int $employeeId
   * @return \Illuminate\Contracts\View\View
   */
  public function leaves($employeeId)
  {
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    return view("employees.leaves", compact("employee"));
  }

  /**
   * Get employee leave request page
   *
   * @param int $employeeId
   * @param int $leaveId
   * @return \Illuminate\Contracts\View\View
   */
  public function leave($employeeId, $leaveId)
  {
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    $leave = $employee->leaves()->find($leaveId);
    if (!$leave || $leave->id != $leaveId) {
      return redirect()->back()->withErrors([__("messages.404.leave")]);
    }

    return view("employees.leave", compact("employee", "leave"));
  }

  /**
   * Save a employee leave request
   *
   * @param  int $employeeId
   * @param  int $leaveId
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function updateLeave($employeeId, $leaveId)
  {
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    $leave = $employee->leaves()->find($leaveId);
    if (!$leave || $leave->id != $leaveId) {
      return redirect()->back()->withErrors([__("messages.404.leave")]);
    }

    $validated = request()->validate([
      'comments' => 'nullable|string',
      'start_date' => 'required|date|before:end_date',
      'end_date' => 'required|date|after:start_date',
      'type' => 'required|in:paid,sick,vacation,parental,unpaid,other',
      'status' => 'required:in:pending,approved,declined',
      'timesheet_id' => 'nullable|exists:timesheets,id',
    ]);

    $validated["comments"] = $validated["comments"] ?? "";
    $validated["approved_user_id"] = null;
    $validated["declined_user_id"] = null;
    $validated["approved_at"] = null;
    $validated["declined_at"] = null;

    if ($validated['status'] === "approved") {
      $validated["approved_user_id"] = $leave->approved ? $leave->approved_user_id : Auth()->user()->id;
      $validated["approved_at"] = $leave->approved ?? Carbon::now();
    } else if ($validated['status'] === "declined") {
      $validated["declined_user_id"] = $leave->declined ? $leave->declined_user_id : Auth()->user()->id;
      $validated["declined_at"] = $leave->declined ?? Carbon::now();
    }

    if ($validated["timesheet_id"] && !$employee->timesheets()->find($validated["timesheet_id"])) {
      return redirect()->back()->withErrors([__("messages.timesheet.bad_owner")]);
    }

    $leave->update($validated);

    if (request()->get("notify") && $leave->status !== "pending" && $leave->wasChanged("status")) {
      $employee->notify($leave->status === 'approved' ? new LeaveApproved($leave) : new LeaveDeclined($leave));
    }

    return redirect()->route("leaves.leave", ["id" => $employeeId, "leaveId" => $leaveId])
      ->with("status", "The leave request was updated");
  }

  /**
   * Create a new employee leave request
   *
   * @param  int $employeeId
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function createLeave($employeeId)
  {
    $employee = Employee::find($employeeId);
    if (!$employee || $employee->id != $employeeId) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    $validated = request()->validate([
      'comments' => 'nullable|string',
      'start_date' => 'required|date|before:end_date',
      'end_date' => 'required|date|after:start_date',
      'type' => 'required|in:paid,sick,vacation,parental,unpaid,other',
      'status' => 'required:in:pending,approved,declined',
      'timesheet_id' => 'nullable|exists:timesheets,id',
    ]);

    $validated["comments"] = $validated["comments"] ?? "";

    if ($validated['status'] === "approved") {
      $validated["approved_user_id"] = Auth()->user()->id;
      $validated["approved_at"] = Carbon::now();
    } else if ($validated['status'] === "declined") {
      $validated["declined_user_id"] = Auth()->user()->id;
      $validated["declined_at"] = Carbon::now();
    }

    if ($validated["timesheet_id"] && !$employee->timesheets()->find($validated["timesheet_id"])) {
      return redirect()->back()->withErrors([__("messages.timesheet.bad_owner")]);
    }

    $leave = $employee->leaves()->create($validated);

    if (request()->get("notify") && $leave->status !== "pending") {
      $employee->notify($leave->status === 'approved' ? new LeaveApproved($leave) : new LeaveDeclined($leave));
    }

    return redirect()->route("employee.leaves", $employeeId);
  }

  /**
   * Update an employee's employment status
   *
   * @param  int $employeeId
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function updateEmploymentStatus($employeeId)
  {
    $employee = Employee::findOrFail($employeeId);

    request()->merge(['terminated_at' => request()->input('employment_status') === "terminated" ? Carbon::now() : null]);
    $employee->update(request()->validate([
      'employment_status' => 'required|in:active,terminated,suspended',
      'terminated_at' => 'nullable|date',
    ]));

    // Update pending leave requests
    if (in_array(request()->input('employment_status'), ["terminated", "suspended"])) {
      $employee->leaves()
        ->whereNull(["approved", "declined"])
        ->update(["declined" => Carbon::now(), "declined_user_id" => auth()->user()->id]);
    }

    return redirect()->route("employees.employee", $employeeId)
      ->with("status", __("messages.employee.status", ["status" => request()->input('employment_status')]));
  }

  /**
   * Update an employee's profile
   *
   * @param  int $employeeId
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function updateProfile($employeeId)
  {
    $employee = Employee::findOrFail($employeeId);

    $employee->update(request()->validate([
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
      'comments' => 'nullable|string',
    ]));

    return redirect()->route("employees.employee", $employeeId)->with("status", "The employee profile was updated");
  }

  /**
   * Send a free-form email to an employee
   *
   * @param  int $employeeId
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function sendEmail($employeeId)
  {
    $employee = Employee::findOrFail($employeeId);

    $validated = request()->validate([
      "subject" => "required|string|max:45",
      "message" => "required|string|max:10000",
    ]);

    Mail::to($employee)->send(new CustomMail($validated['subject'], $validated['message']));

    return redirect()->route("employees.employee", $employeeId)->with("status", "Email sent to employee");
  }

  /**
   * Generate a PDF of an employee timesheet
   *
   * @param int $employeeId
   * @param int $year
   * @param int $month
   * @return \Illuminate\Contracts\View\View
   */
  public function timesheetExport($employeeId, $year, $month)
  {
    // Validate Employee
    if (!$employeeId || !($employee = Employee::find($employeeId))) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }

    // Get Timesheet
    if (!checkdate($month, 1, $year)) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }
    if (!($timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first())) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }

    return response()->make($timesheet->toPDF()->output("S"), 201, [
      "Content-Type" => "application/pdf",
      "Content-Disposition" => "inline; filename=timesheet.pdf",
    ]);
  }

  /**
   * Send a custom email with a timesheet attached
   *
   * @param  int $employeeId
   * @param  int $year
   * @param  int $month
   * @return \Illuminate\Support\Facades\Redirect
   */
  public function sendTimesheetEmail($employeeId, $year, $month)
  {
    // Validate Input
    if (!is_numeric($employeeId) || !($employee = Employee::find($employeeId))) {
      return redirect()->back()->withErrors([__("messages.404.employee")]);
    }
    if (!checkdate($month, 1, $year)) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }
    if (!($timesheet = $employee->timesheets()->where("period", "$year-$month-01")->first())) {
      return redirect()->back()->withErrors([__("messages.404.timesheet")]);
    }

    $validated = request()->validate([
      "subject" => "required|string|max:45",
      "message" => "required|string|max:10000",
      "recipient" => "required|array",
      "recipient.*" => "required|string|email|max:255",
    ]);

    foreach ($validated['recipient'] as $recipient) {
      Mail::to($recipient)
        ->send((new CustomMail($validated['subject'], $validated['message'], $timesheet))
            ->attachData($timesheet->toPDF()->output("S"), "timesheet.pdf"));
    }

    return redirect()->route("employee.timesheet", [
      "id" => $employeeId,
      "year" => $timesheet->period->format("Y"),
      "month" => $timesheet->period->format("m"),
    ])->with("status", "Email sent to the specified recipient(s)");
  }
}
