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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lname')->nullable()->after('name');
            $table->string('alternate_phone')->nullable()->after('phone');
            $table->integer('state')->nullable()->after('alternate_phone');
            $table->integer('city')->nullable()->after('state');
            $table->string('zipcode')->nullable()->after('city');
            $table->string('profile_image')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lname');
            $table->dropColumn('alternate_phone');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('zipcode');
            $table->dropColumn('profile_image');
        });
    }
};
