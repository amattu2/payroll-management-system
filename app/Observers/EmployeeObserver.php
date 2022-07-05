<?php
/*
 * Produced: Wed Jun 29 2022
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

namespace App\Observers;

use App\Models\Employee;
use App\Notifications\EmployeeCreated;
use App\Notifications\EmployeeDeleted;
use App\Notifications\EmployeeUpdated;
use Illuminate\Support\Facades\Notification;

class EmployeeObserver
{
  public $afterCommit = true;

  /**
   * Handle the Employee "created" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function created(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeCreated($employee));
  }

  /**
   * Handle the Employee "updated" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function updated(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeUpdated($employee));
  }

  /**
   * Handle the Employee "deleted" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function deleted(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeDeleted($employee));
  }

  /**
   * Handle the Employee "restored" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function restored(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeUpdated($employee));
  }

  /**
   * Handle the Employee "force deleted" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function forceDeleted(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeDeleted($employee));
  }
}
