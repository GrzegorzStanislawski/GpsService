<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GPS_CACHE', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->double('LAT', 8, 2);
            $table->double('LNG', 8, 2);
            $table->string('ADDRESS', 500);
            $table->integer('USED', 0);
            $table->dateTime('CREATED_AT');
            $table->string('CREATED_BY', 50);
            $table->enum('DELETE_YN', ['Y', 'N']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GPS_CACHE');
    }
}
