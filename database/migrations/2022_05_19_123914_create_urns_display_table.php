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
        if(!Schema::hasTable('urns_display')){
            Schema::create('urns_display', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('image')->nullable();
                $table->longText('content')->nullable();
                $table->tinyInteger('status')->default(1)->comment('1-Active,0-Inactive');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urns_display');
    }
};
