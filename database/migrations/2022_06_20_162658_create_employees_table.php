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
        Schema::dropIfExists('employees');

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->date('birthdate');
            $table->date('hired_at');
            $table->timestamp('terminated_at')->nullable();
            $table->enum('pay_type', ['hourly', 'salary'])->default('hourly');
            $table->enum('pay_period', ['daily', 'weekly', 'biweekly', 'monthly'])->default('monthly');
            $table->decimal('pay_rate', 15, 2)->default(0);
            $table->string('title');
            $table->enum('employment_status', ['active', 'terminated', 'suspended'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
