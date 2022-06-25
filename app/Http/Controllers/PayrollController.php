<?php
/*
 * Produced: Fri Jun 24 2022
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
  /**
   * Get the index page
   *
   * @param int $id
   * @param int $year
   * @param int $month
   * @return \Illuminate\Contracts\View\View
   */
  public function index($id, $year = null, $month = null)
  {
    // Validate Employee
    $employee = DB::table('employees')->where('id', $id)->first();
    if (!$employee) {
      return redirect()->back()->withErrors([
        "The requested employee was not found"
      ]);
    }

    // Validate date inputs
    if (!checkdate($month ?? (int) date("m"), 1, $year ?? (int) date("Y"))) {
      return redirect()->back()->withErrors([
        "The requested date was invalid"
      ]);
    }

    return view('payroll.index', [
      'employee' => $employee,
      'employees' => DB::table('employees')->get()
    ]);
  }
}
