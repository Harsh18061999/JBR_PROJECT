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
        Schema::table('rea_allocates', function (Blueprint $table) {
            $table->string('time_sheet_image')->after('re_allocate_date')->nullable();
            $table->enum('time_sheet',['0','1'])->after('time_sheet_image')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rea_allocates', function (Blueprint $table) {
            $table->dropColumn(['time_sheet_image','time_sheet']);
        });
    }
};
