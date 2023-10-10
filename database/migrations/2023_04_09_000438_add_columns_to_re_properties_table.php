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
        Schema::table('re_properties', function (Blueprint $table) {
            $table->tinyInteger('number_garages')->after('price')->default(0)->nullable();
            $table->tinyInteger('floor_no')->after('number_garages')->default(0)->nullable();
            $table->string('invisible_notes')->after('floor_no')->nullable();
            $table->tinyInteger('elevator')->after('floor_no')->nullable()->default(0);
            $table->date('available_from')->after('floor_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('re_properties', function (Blueprint $table) {
            //
        });
    }
};
