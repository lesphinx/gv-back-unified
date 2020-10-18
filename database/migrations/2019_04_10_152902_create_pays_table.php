<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreatePaysTable
|
|
|
|*/



class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {




            Schema::create('pays', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom')->nullable();
                $table->string('nicename')->nullable();
                $table->string('iso',2)->nullable();
                $table->string('iso3',3)->nullable();
                $table->integer('numcode')->nullable();
                $table->integer('phonecode')->nullable();
                $table->string('flag')->nullable();
                $table->string('slug')->nullable();
                $table->integer('capitale')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pays');
    }


}
