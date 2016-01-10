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
			$table->integer('issue');
			$table->integer('articleNo');
			$table->string('articleHeading')->nullable();
			$table->string('author');
			$table->boolean('hasAd')->default(false);
			$table->string('adImage')->default(null);
			$table->timestamps();
			$table->unique(array('issue','articleNo'));
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
