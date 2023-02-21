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
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('supervisor_id');
            $table->integer('job_id');
            $table->date('job_date');
            $table->date('end_date')->nullable();
            $table->integer('hireperiod')->default(1);
            $table->bigInteger('no_of_employee');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->enum('status',[0,1,2,3])->defalt(0)->comment('0:pending,1:ongoing,2:completed,3:incomplet');;
            $table->enum('job_message_status',[0,1,2])->defalt(0);
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
        Schema::dropIfExists('job_requests');
    }
};
