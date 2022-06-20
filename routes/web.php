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
})->name("logout");

Route::prefix('authenticate')->group(function() {
  if (Auth::check()) {
    return redirect()->route('home')->withErrors([
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
      return redirect()->route('home');
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

    return redirect()->route('home');
  })->name("auth.create");
});

/*
 * Normal Routes
 */
Route::middleware(['auth', 'auth.session'])->group(function() {
  // Home
  Route::get('/', function() {
    return view('home');
  })->name("home");
});
