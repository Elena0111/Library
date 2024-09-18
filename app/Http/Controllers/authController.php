<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function authentication() {
        return view('auth.auth');
    }

    public function logout() {
        session_start();
        session_destroy();
        return Redirect::to(route('home'));
    }

    public function login(Request $req) {
        session_start();
        $dl = new DataLayer();

        if ($dl->validUser($req->input('username'), $req->input('password'))) 
        {
            $user_name = $dl->getUserName($req->input('username'));
            $_SESSION['logged'] = true;
            $_SESSION['loggedName'] = $user_name;
            $_SESSION['loggedEmail'] = $req->input('username');
            return Redirect::to(route('book.index'));

        }
        return view('auth.authErrorPage');
    }

    public function registration(Request $req) {
        $dl = new DataLayer();
        
        $dl->addUser($req->input('name'), $req->input('password'), $req->input('email'));
       
        return Redirect::to(route('user.login'));
    }

    public function registrationCheckForEmail(Request $req) {
        $dl = new DataLayer();
        
        if($dl->checkEmail($req->input('email')))
        {
            $response = array('found'=>true);
        } else {
            $response = array('found'=>false);
        }
        return response()->json($response);
    }
}
