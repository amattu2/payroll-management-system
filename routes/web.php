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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication Routes
 */
Route::prefix('authenticate')->group(function() {
  Route::any('logout.do', [AuthController::class, 'logout'])->name("auth.logout");

  Route::get('login', [AuthController::class, 'loginForm'])->name("auth.login");
  Route::post('login.do', [AuthController::class, 'login'])->name("auth.check");

  Route::get('register', [AuthController::class, 'registerForm'])->name("auth.register");
  Route::post('register.do', [AuthController::class, 'register'])->name("auth.create");
});

/*
 * Normal Routes
 */
Route::middleware(['auth', 'auth.session'])->group(function() {
  /*
   * Top Level Routes
   */
  Route::get('/', [Controller::class, 'index'])->name("index");

  /*
   * Payroll Routes
   */
  Route::middleware(["can:employees.view.all"])->group(function() {
    Route::get('/payroll/{id}/{year?}/{month?}', [PayrollController::class, 'index'])->name("payroll");
  });

  /*
   * Employee Management Routes
   */
  Route::middleware(["can:employees.view.all"])->group(function() {
    Route::get('/employees', [EmployeeController::class, 'index'])->name("employees");
    Route::post('/employees', [EmployeeController::class, 'create'])->name("employees.create");
    Route::get('/employees/{id}', [EmployeeController::class, 'employee'])->name("employees.employee");
  });

  /*
   * Settings Routes
   */
  Route::middleware(["can:edit-settings"])->group(function() {
    Route::get('/settings', [SettingsController::class, 'index'])->name("settings");
  });

  /*
   * Report Routes
   */
  Route::middleware(["can:edit-settings"])->group(function() {
    Route::get('/reports', [ReportController::class, 'index'])->name("reports");
    Route::get('/reports/{report}', [ReportController::class, 'index'])->name("reports.report");
  });

  /*
   * 404 Fallback
   */
  Route::fallback(function($slug) {
    return view("404", ["slug" => $slug]);
  });
});
