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
            $table->string('sin')->unique();
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->integer('country')->nullable();
            $table->integer('provience')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('transit_number')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('personal_identification')->nullable();
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
        Schema::dropIfExists('employee_data_entry_points');
    }
};
