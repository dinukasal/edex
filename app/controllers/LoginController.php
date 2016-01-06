<?php

class LoginController extends BaseController{

	public $restful = true;

	public function getIndex(){
		return View::make('users.index')
		->with('title','This is my fisrt laravel!')
		->with('users',User::all());
	}
	public function login(){
		$username=$_POST['username'];
		$pwd=$_POST['password'];
		session_start();
		if($username!=''){
			$user=User::where('username','=',$username)->get();
		}else{
			return View::make('login')->with('title','Please Login!');
		}
		if($user!=[]){
			if($user[0]['password']==$pwd){
				$_SESSION['username']=$username;
				//return 'ok';
				//return View::make('test');
				
				return View::make('displayMagazines')
				->with('title','All Magazines')
				->with('magazines',Magazine::all());
				
			}else{
				$_SESSION['username']='';
				return View::make('login')->with('title','Enter Correct Password!');
			}
		}else{
			return View::make('login')->with('title','Please Login!');
		}
	}
	public function logout(){
		if(isset($_SESSION['username'])){
			$_SESSION['username']='';
		}else{
			session_start();
			$_SESSION['username']='';
		}
		return View::make('login')->with('title','Please Login!');
	}
}