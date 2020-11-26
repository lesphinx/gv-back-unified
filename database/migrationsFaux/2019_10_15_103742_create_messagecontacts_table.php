<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateMessagecontactsTable
|
|
|
|*/



class CreateMessagecontactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('messagecontacts', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
$table->string('email');
$table->string('telephone');
$table->text('message');
$table->string('slug');

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
        Schema::drop('messagecontacts');
    }

     /* --Generated with ❤ by Slugger ---*/

}
