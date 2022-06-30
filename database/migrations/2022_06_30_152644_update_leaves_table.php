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
        Schema::table('leaves', function(Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending')->index();
            $table->renameColumn('approved', 'approved_at');
            $table->renameColumn('declined', 'declined_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function(Blueprint $table) {
            $table->dropColumn('status');
            $table->renameColumn('approved_at', 'approved');
            $table->renameColumn('declined_at', 'declined');
        });
    }
};
