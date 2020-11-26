<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateLocationsTable
|
|
|
|*/



class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('sites', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('province');

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
        Schema::drop('sites');
    }


}