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
        Schema::create('job_reminders', function (Blueprint $table) {
            $table->id();
            $table->integer('job_confirmations_id');
            $table->enum('job_reminder',['0','1'])->default('0');
            $table->enum('time_sheet_reminder',['0','1'])->default('0');
            $table->date('reminder_date')->nullable();
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
        Schema::dropIfExists('job_reminders');
    }
};
