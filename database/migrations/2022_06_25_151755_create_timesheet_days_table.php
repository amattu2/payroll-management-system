<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet_days', function (Blueprint $table) {
            $table->id();
            $table->date("date")->index();
            $table->string("description")->nullable();
            $table->time("start_time");
            $table->time("end_time");
            $table->decimal("adjustment", 5, 2)->default(0);
            $table->decimal("total_units", 5, 2)->default(0);
            $table->foreignId('timesheet_id')->references('id')->on('timesheets');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(["date", "timesheet_id", "deleted_at"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheet_days');
    }
};
