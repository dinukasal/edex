<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('login')->insert(array(
			'username'=>'admin',
			'password'=>  \Illuminate\Support\Facades\Hash::make('1234'),
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('login')->insert(array(
			'username'=>'demo',
			'password'=>\Illuminate\Support\Facades\Hash::make('1234'),
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
			));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('login')->delete('0');
		DB::table('login')->delete('1');
	}

}
