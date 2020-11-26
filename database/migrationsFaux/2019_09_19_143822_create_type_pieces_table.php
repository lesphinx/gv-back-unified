<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_pieces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->string('libelle');

            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('type_pieces')
            ->insert(
                array(
                    array('libelle'=>'CNI'),
                    array('libelle'=>'Passeport'),
                    array('libelle'=>'Carte de séjour'),
                    array('libelle'=>'Carte d\'étudiant'),
                    array('libelle'=>'Permis de Conduire'),
                )
            );

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_pieces');
    }
}
