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
        Schema::create('job_confirmations', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('job_id');
            $table->enum('status',['0','1'])->default('0');
            $table->enum('job_status',['0','1','2','3'])->default(0);
            $table->enum('time_sheet',['0','1'])->default('0');
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
        Schema::dropIfExists('job_confirmations');
    }
};
