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
        Schema::create('employee_time_sheets', function (Blueprint $table) {
            $table->id();
            $table->integer("job_confirmations_id");
            $table->string('start_time')->nullable();
            $table->string('break_time')->nullable();
            $table->string('end_time')->nullable();
            $table->date('job_date')->nullable();
            $table->enum("status",['0','1','2'])->default('0');
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
        Schema::dropIfExists('employee_time_sheets');
    }
};
