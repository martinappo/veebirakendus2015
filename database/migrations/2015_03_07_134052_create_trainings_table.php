<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trainings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('aadress');
			$table->string('coordinates');
			$table->boolean('confirmed');
			$table->enum('type', ['open', 'closed']);
			$table->mediumText('description');
			$table->double('rating');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trainings');
	}

}
