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

use App\Models\Leave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Get application index
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    $openLeaves = Cache::remember('openLeaves', 60*5, function () {
      return Leave::where("status", "pending")
        ->where("start_date", ">=", date("Y-m-d"))
        ->orderBy("created_at")
        ->get();
    });

    $upcomingLeaves = Cache::remember('upcomingLeaves', 60*60, function () {
      return Leave::where("status", "approved")
        ->where("start_date", ">=", date("Y-m-d"))
        ->where("start_date", "<=", date("Y-m-d", strtotime("+3 weeks")))
        ->orderBy("start_date")
        ->get();
    });

    return view('index', compact("openLeaves", "upcomingLeaves"));
  }
}
