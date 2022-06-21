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

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
 * Authentication Routes
 */

Route::any("logout.do", function(Request $r) {
  // Logout user
  Auth::logout();

  // Destroy session
  $r->session()->invalidate();
  $r->session()->regenerateToken();

  // Redirect to login
  return redirect('/');
})->name("auth.logout");

Route::prefix('authenticate')->group(function() {
  if (Auth::check()) {
    return redirect()->route('index')->withErrors([
      "You are already logged in"
    ]);
  }

  Route::get('login', function() {
    return view('auth.login');
  })->name("auth.login");

  Route::post('login.do', function() {
    // Validate request
    $request = request()->validate([
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:8',
    ]);

    if (Auth::attempt($request, request('remember'))) {
      return redirect()->route('index');
    }

    return redirect()->back()->withErrors(["Bad authentication"]);
  })->name("auth.check");

  Route::get('register', function() {
    return view('auth.register');
  })->name("auth.register");

  Route::post('register.do', function() {
    $validated = request()->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
    ]);
    Auth::login($user);

    return redirect()->route('index');
  })->name("auth.create");
});

/*
 * Normal Routes
 */
Route::middleware(['auth', 'auth.session'])->group(function() {
  $employees = DB::table('employees')->get();

  // Index
  Route::get('/', function() use ($employees) {
    return view('index', ["employees" => $employees]);
  })->name("index");

  Route::get('/employees', function() use ($employees) {
    return view('employees.index', ["employees" => $employees]);
  })->name("employees");

  Route::post('/employees', function() {
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
  });

  Route::get('/employees/{id}', function($id) use ($employees) {
    if (is_numeric($id)) {
      $employee = DB::table('employees')->where('id', $id)->first();

      if (!$employee) {
        return redirect()->route('employees')->withErrors(["The requested employee was not found"]);
      }

      return view('employees.employee', [
        "employee" => $employee,
        "employees" => $employees
      ]);
    } else {
      return view('employees.create', ["employees" => $employees]);
    }
  })->name("employees.employee");

  Route::get('/reports', function() {
    return "Not supported yet";
  })->name("reports");

  Route::get('/reports/{report}', function($report) {
    return $report . " is not supported yet";
  })->name("reports.report");

  Route::get('/integrations', function() {
    return "Not supported yet";
  })->name("integrations");

  Route::get('/settings', function() {
    return "Not supported yet";
  })->name("settings");
});
