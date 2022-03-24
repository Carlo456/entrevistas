<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function renderForm(){
        if (Auth::check()) {
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            return view('form',[ 'name' => $name, 'email' => $email ]);
        } else {
            return view('/');
        }
    }
}
