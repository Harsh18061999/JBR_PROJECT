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
        Schema::table('proviences', function (Blueprint $table) {
            $table->string('gmt_time')->nullable()->after('provience_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proviences', function (Blueprint $table) {
            $table->droupColumn(['gmt_time']);
        });
    }
};
