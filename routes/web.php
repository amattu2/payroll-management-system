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

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SettingsController;

/**
 * Authentication Routes
 */
Route::middleware(['throttle:web'])->prefix("auth")->group(function () {
  Route::any('logout.do', [AuthController::class, 'logout'])->name("auth.logout");

  Route::get('login', [AuthController::class, 'loginForm'])->name("auth.login");
  Route::post('login.do', [AuthController::class, 'login'])->name("auth.check");

  Route::get('password-confirm', [AuthController::class, 'passwordForm'])->name("password.confirm");
  Route::post('password-confirm.do', [AuthController::class, 'passwordConfirm'])->name("confirm.check");

  Route::get('register', [AuthController::class, 'registerForm'])->name("auth.register");
  Route::post('register.do', [AuthController::class, 'register'])->name("auth.create");
});

/*
 * Normal Routes
 */
Route::middleware(['auth', 'auth.session', 'throttle:web'])->group(function () {
  /*
   * Top Level Routes
   */
  Route::get('/', [Controller::class, 'index'])->name("index");

  /*
   * Employee Management Routes
   */
  Route::group(["middleware" => ["can:employees.view.all"], "prefix" => "employees"], function () {
    /**
     * Get Routes
     */
    Route::get('/', [EmployeeController::class, 'index'])->name("employees");
    Route::get('/{id}', [EmployeeController::class, 'employee'])->name("employees.employee");
    Route::get('/{id}/timesheet/{year?}/{month?}', [EmployeeController::class, 'timesheet'])->name("employee.timesheet");
    Route::get('/{id}/timesheet/{year}/{month}/export', [EmployeeController::class, 'timesheetExport'])->name("timesheet.export");
    Route::get('/{id}/leaves', [EmployeeController::class, 'leaves'])->name("employee.leaves");
    Route::get('/{id}/leaves/{leaveId}', [EmployeeController::class, 'leave'])->name("leaves.leave");

    /**
     * Create Routes
     */
    Route::post('/', [EmployeeController::class, 'create'])
      ->name("employees.create");
    Route::post('/{id}/leaves', [EmployeeController::class, 'createLeave'])
      ->name("leaves.create");
    Route::post('/{id}/email', [EmployeeController::class, 'sendEmail'])
      ->name("employee.email.create");
    Route::post('/{id}/timesheet/{year}/{month}/email', [EmployeeController::class, 'sendTimesheetEmail'])
      ->name("timesheet.email");

    /**
     * Update Routes
     */
    Route::post('/{id}/update/employment_status', [EmployeeController::class, 'updateEmploymentStatus'])
      ->name("employees.update.employment_status");
    Route::post('/{id}/timesheet/{year}/{month}/settings', [EmployeeController::class, 'updateTimesheetSettings'])
      ->name("timesheet.settings");
    Route::post('/{id}/update/profile', [EmployeeController::class, 'updateProfile'])
      ->name("employees.update.profile");
    Route::post('/{id}/leaves/{leaveId}/update', [EmployeeController::class, 'updateLeave'])
      ->name("leave.update");
    Route::post('/{id}/timesheet/update/{year}/{month}', [EmployeeController::class, 'updateTimesheet'])
      ->name("timesheet.update");
  });

  /*
   * Settings Routes
   */
  Route::middleware(["can:edit-settings", "password.confirm"])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name("settings");
  });

  /*
   * Report Routes
   */
  Route::middleware(["can:edit-settings"])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name("reports");
    Route::get('/reports/{report}', [ReportController::class, 'index'])->name("reports.report");
  });

  /*
   * 404 Fallback
   */
  Route::fallback(function ($slug) {
    return view("404", ["slug" => $slug]);
  });
});
