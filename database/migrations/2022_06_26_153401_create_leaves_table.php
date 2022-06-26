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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->text('comments');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('approved')->nullable();
            $table->foreignId('approved_user_id')->nullable()->references('id')->on('users');
            $table->dateTime('declined')->nullable();
            $table->foreignId('declined_user_id')->nullable()->references('id')->on('users');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->foreignId('timesheet_id')->nullable()->references('id')->on('timesheets');
            $table->enum('type', ['paid', 'sick', 'vacation', 'parental', 'unpaid', 'other']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
};
