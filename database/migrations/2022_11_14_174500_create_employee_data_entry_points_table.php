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
        Schema::create('employee_data_entry_points', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('sin');
            $table->string('line_1');
            $table->string('line_2');
            $table->integer('country');
            $table->integer('provience');
            $table->integer('city_id');
            $table->string('postal_code');
            $table->string('transit_number');
            $table->string('institution_number');
            $table->string('account_number');
            $table->string('personal_identification')->nullable();
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
        Schema::dropIfExists('employee_data_entry_points');
    }
};
