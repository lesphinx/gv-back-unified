<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuizquestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quizquestion', function(Blueprint $table)
		{
			$table->integer('id');
			$table->integer('quizId')->index('FK_quizQuestion');
			$table->primary(['id','quizId']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quizquestion');
	}

}
