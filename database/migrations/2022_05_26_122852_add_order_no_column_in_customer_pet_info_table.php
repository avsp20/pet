<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_pet_info', function (Blueprint $table) {
            $statement = "ALTER TABLE customer_pet_info AUTO_INCREMENT = 10000;";
            DB::unprepared($statement);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_pet_info', function (Blueprint $table) {
            
        });
    }
};
