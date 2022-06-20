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

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

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

    return redirect()->back()->withErrors([
      "Bad authentication"
    ]);
  })->name("auth.check");

  Route::get('register', function() {
    return view('auth.register');
  })->name("register")->name("auth.register");

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
  // Index
  Route::get('/', function() {
    $employees = DB::table('employees')->get();

    return view('index', ["employees" => $employees]);
  })->name("index");

  Route::get('/employees', function() {
    $employees = DB::table('employees')->get();

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
      'datehired' => 'required|date',
      'paytype' => 'required|in:hourly,salary',
      'payperiod' => 'required|in:daily,weekly,biweekly,monthly',
      'salary' => 'required|numeric',
      'title' => 'required|string|max:255',
    ]);

    Employee::create($validated);

    return Redirect::back()->withErrors("Not supported yet");
  });

  Route::get('/employees/{id}', function($id) {
    if (is_numeric($id)) {
      $employee = DB::table('employees')->where('id', $id)->first();

      //return view('employees.employee', ["employee" => $employee]);
    } else {
      return view('employees.create');
    }
  })->name("employees.employee");

  Route::get('/reports', function() {
    return view('index');
  })->name("reports");

  Route::get('/integrations', function() {
    return view('index');
  })->name("integrations");

  Route::get('/settings', function() {
    return view('index');
  })->name("settings");
});
