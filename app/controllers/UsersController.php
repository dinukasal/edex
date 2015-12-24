<?php

class UsersController extends BaseController{

	public $restful = true;

	public function getIndex(){
		return View::make('users.index')
		->with('title','This is my fisrt laravel!')
		->with('users',User::all());
	}
}