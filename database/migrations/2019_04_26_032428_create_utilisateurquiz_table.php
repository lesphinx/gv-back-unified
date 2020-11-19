<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUtilisateurquizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('utilisateurquiz', function(Blueprint $table)
		{
			$table->integer('quizId');
			$table->integer('customers_id')->index('FK_utilisateurQuiz');
			$table->integer('id')->nullable();
			$table->integer('bonus')->nullable();
			$table->primary(['quizId','customers_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('utilisateurquiz');
	}

}
