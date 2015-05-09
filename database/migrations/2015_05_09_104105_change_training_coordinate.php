<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTrainingCoordinate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trainings', function(Blueprint $table)
		{
			$table->dropColumn('coordinates');
			$table->string('longitude');
			$table->string('latitude');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('longitude');
			$table->dropColumn('latitude');
			$table->string('cooridnates');
		});
	}

}
