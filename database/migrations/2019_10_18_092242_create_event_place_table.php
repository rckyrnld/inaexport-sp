<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_place', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_in')->nullable();
            $table->string('name_chn')->nullable();
            $table->text('addres_en')->nullable();
            $table->text('addres_in')->nullable();
            $table->text('addres_chn')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email_in')->nullable();
            $table->string('email_en')->nullable();
            $table->string('email_chn')->nullable();
            $table->text('website_en')->nullable();
            $table->text('website_in')->nullable();
            $table->text('website_chn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_place');
    }
}
