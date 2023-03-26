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

namespace App\Console\Commands;

use App;
use Illuminate;
use Illuminate\Console\Command;

class Factories extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'run:factories';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Run the database test factories';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    // Delete old data
    Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    App\Models\Employee::truncate();
    App\Models\Leave::truncate();
    App\Models\Timesheet::truncate();
    App\Models\TimesheetDay::truncate();
    Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Disable Observer
    App\Models\Employee::unsetEventDispatcher();

    // Create new models
    App\Models\Employee::factory()->count(rand(6, 45))
      ->has(App\Models\Timesheet::factory()->count(rand(1, 8))
          ->has(App\Models\TimesheetDay::factory()->count(rand(1, 22))))
      ->has(App\Models\Leave::factory()->count(rand(1, 3)))
      ->create();

    return Command::SUCCESS;
  }
}
