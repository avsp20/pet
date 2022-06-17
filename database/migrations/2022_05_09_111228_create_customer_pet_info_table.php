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
        if(!Schema::hasTable('customer_pet_info')){
            Schema::create('customer_pet_info', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('location')->unsigned()->nullable();
                $table->foreign('location')->references('id')->on('users')->onDelete('cascade');
                $table->string('tag')->nullable();
                $table->string('pet_name')->nullable();
                $table->integer('pet_type')->nullable();
                $table->integer('pet_status')->nullable();
                $table->integer('gender')->default(0)->nullable();
                $table->string('age')->nullable();
                $table->string('weight')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('breed_and_color')->nullable();
                $table->text('additional_pet_info')->nullable();
                $table->string('date_received')->nullable();
                $table->string('date_cremated')->nullable();
                $table->string('date_delivered')->nullable();
                $table->text('processing_checklist')->nullable();
                $table->integer('cremation_type')->nullable();
                $table->integer('frame_color')->nullable();
                $table->text('urn_details')->nullable();
                $table->longText('special_info')->nullable();
                $table->longText('additional_items')->nullable();
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
        Schema::dropIfExists('customer_pet_info');
    }
};
