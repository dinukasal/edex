<?php

use Illuminate\Support\Facades\Request;

class LoginController extends BaseController {

    public $restful = true;

    public function getIndex() {
        return View::make('users.index')
                        ->with('title', 'This is my fisrt laravel!')
                        ->with('users', User::all());
    }

    /**
     * Logs in a user
     * @param Illuminate\Support\Facades\Request $request
     * @return type
     */
    public function login() {
        if (Auth::attempt(['username' => Input::get('username'),
                    'password' => Input::get('password')])) {
        
            return View::make('displayMagazines')
                        ->with('title', 'All Magazines')
                        ->with('magazines', Magazine::all());
        } else {
            return Redirect::back()->with('error',"Login is incorrect");
        }
    }

    public function logout() {
        if(Auth::check()){
            Auth::logout();
        }
        return Redirect::to('/login');
    }

}
