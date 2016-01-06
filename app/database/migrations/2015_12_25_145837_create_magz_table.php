<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagzTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazines',function($table){
			$table->increments('id');
			$table->string('issue')->unique();
			$table->string('heading');
			$table->binary('image');
			$table->date('date');
			$table->timestamps();
			//$table->binary('data');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('magazines');
	}

}
