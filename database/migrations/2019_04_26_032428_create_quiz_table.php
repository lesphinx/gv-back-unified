<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quiz', function(Blueprint $table)
		{
			$table->integer('quizId', true);
			$table->integer('id')->nullable()->index('FK_association34');
			$table->string('quizTitre', 254)->nullable();
			$table->dateTime('quizDebut')->nullable();
			$table->dateTime('quizFin')->nullable();
			$table->integer('quizNbreQuestion')->nullable();
			$table->dateTime('quizCreatedAt')->nullable();
			$table->dateTime('quizUpdatedAt')->nullable();
			$table->integer('quizPointGagnant')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quiz');
	}

}
