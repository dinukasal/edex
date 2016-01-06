<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articlesList',function($table){
			$table->increments('id');
			$table->string('issue');
			$table->integer('articleNo')->unique();
			$table->string('articleHeading')->nullable();
			$table->string('author');
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
		Schema::drop('articlesList');
	}

}
