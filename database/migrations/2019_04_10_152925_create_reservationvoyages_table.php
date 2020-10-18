<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateReservationvoyagesTable
|
|
|
|*/



class CreateReservationvoyagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('reservationvoyages', function(Blueprint $table) {
                $table->increments('id');
                $table->dateTime('date_reservation')->nullable();
                $table->dateTime('date_validation')->nullable();
                $table->dateTime('dateVoyage')->nullable();
                $table->float('prix_voyage')->nullable(true);
                $table->integer('statut');
                $table->string('nom_voyageur')->nullable();
                $table->string('prenom_voyageur')->nullable();
                $table->string('slug')->nullable();
                $table->unsignedInteger('age_voyageur')->nullable();
                $table->string('numero_piece');
                $table->unsignedInteger('type_piece');
                $table->unsignedInteger('billet')->nullable();
                $table->unsignedInteger('client');
                $table->unsignedInteger('classe');
                $table->unsignedInteger('voyage');

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
        Schema::drop('reservationvoyages');
    }


}
