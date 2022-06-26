<?php

namespace App\Console\Commands;

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
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Employee::truncate();
        \App\Models\Leave::truncate();
        \App\Models\Timesheet::truncate();
        \App\Models\TimesheetDay::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create new models
        \App\Models\Employee::factory()->count(rand(6, 45))
          ->has(\App\Models\Timesheet::factory()->count(rand(1, 2))
            ->has(\App\Models\TimesheetDay::factory()->count(1)))
          ->has(\App\Models\Leave::factory()->count(rand(0, 3)))
          ->create();

        return 0;
    }
}
