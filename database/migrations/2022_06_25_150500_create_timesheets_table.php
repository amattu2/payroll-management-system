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
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->date("period")->index();
            $table->enum("pay_type", ["hourly", "salary"])->default("hourly");
            $table->foreignId('edit_user_id')->references('id')->on('users');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->dateTime("completed_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(["period", "employee_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
};
