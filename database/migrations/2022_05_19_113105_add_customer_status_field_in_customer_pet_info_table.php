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
        Schema::table('customer_pet_info', function (Blueprint $table) {
            $table->integer('customer_status')->nullable()->after('pet_status');
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
            $table->dropColumn('customer_status');
        });
    }
};
