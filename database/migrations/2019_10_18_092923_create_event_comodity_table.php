<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventComodityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_comodity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kode')->nullable();
            $table->string('comodity_en')->nullable();
            $table->string('comodity_in')->nullable();
            $table->string('comodity_chn')->nullable();
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
        Schema::dropIfExists('event_comodity');
    }
}
