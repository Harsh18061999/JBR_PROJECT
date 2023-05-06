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
        Schema::table('employee_time_sheets', function (Blueprint $table) {
            $table->integer('job_confirmations_id')->change()->nullable();
            $table->integer('re_allocation_id')->after('job_confirmations_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_time_sheets', function (Blueprint $table) {
            $table->deropColumn(['job_confirmations_id','re_allocation_id']);
        });
    }
};
