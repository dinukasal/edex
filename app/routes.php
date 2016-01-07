<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('addmag',function(){
	if(Magazine::all()->count()>0){
		return View::make('uploadMagazine')->with('title','Enter Magazine Details')
		->with('issue',Magazine::all()[Magazine::all()->count()-1]['issue']+1);
	}else{
		return View::make('uploadMagazine')->with('title','Enter Magazine Details')
		->with('issue',1);
	}
});


Route::get('addarticle/{issue}',['uses'=>'ArticleController@viewForm']);

Route::get('addarticle',['uses'=>'ArticleController@viewForm']);


Route::get('listarticles/{issue}',['uses'=>'ArticleController@listArticles']);

Route::post('submitarticle','ArticleController@saveArticle');

Route::get('deletearticle/{issue}/{articleno}',['uses'=>'MagazineController@deleteArticle']);

Route::post('deletemultiplearticles',['uses'=>'ArticleController@deleteMultiple']);

Route::get('viewarticle/{issue}/{articleno}',['uses'=>'ArticleController@getArticle']);

Route::get('editarticle/{issue}/{articleno}',['uses'=>'ArticleController@editArticle']);

Route::post('updatearticle',['uses'=>'ArticleController@updateArticle']);


Route::get('login',function(){
	return View::make('login')->with('title','Please Login!');
});

Route::get('list','MagazineController@listMagazines');

Route::post('auth','LoginController@login');

Route::get('logout','LoginController@logout');

Route::post('submitmag','MagazineController@saveMagazine');

Route::get('view','MagazineController@getMagazines');

Route::get('viewmag/{issue}',['uses'=>'MagazineController@getMagazineByIssue']);

Route::get('deletemagazine/{issue}',['uses'=>'MagazineController@deleteMagazine']);

Route::post('deletemultiple',['uses'=>'MagazineController@deleteMultiple']);

Route::get('test',function(){

	return View::make('exampleForm');
});

//Route::get('test/{request}/{issue}/{article}',['uses'=>'TestController@test']);

//Route::post('test',['uses'=>'TestController@test']);

Route::post('getdata',['uses'=>'MagazineController@getJsonData']);

Route::get('getdata',function(){
	return View::make('exampleForm')->with('title','Please Login!');
});