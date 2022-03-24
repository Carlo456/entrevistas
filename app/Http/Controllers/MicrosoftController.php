<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MicrosoftController extends Controller
{
    public function redirectMicrosoft(){
        return Socialite::driver('microsoft')->redirect();
    }
    public function callbackMicrosoft(){
        try {
            $msUser = Socialite::driver('microsoft')->user();
            $findUser = User::where('ms_id', $msUser->id)->first();

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('form');
            } else {
                $hashed_random_password = Hash::make(Str::random(40));
                $newUser = User::create([
                    'name' => $msUser->name,
                    'email' => $msUser->email,
                    'password' => $hashed_random_password,
                    'ms_id' => $msUser->id
                ]);
                Auth::login($newUser);
                return redirect()->intended('form');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
