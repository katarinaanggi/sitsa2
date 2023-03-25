<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login', [
            "title" => "Login"
        ]);
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email:dns|exists:users,email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ],
        [
            'g-recaptcha-response.required' => 'Tolong lakukan verfikasi bahwa anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! Coba lagi nanti.',
            'email.exists' => 'Email tidak terdaftar',
            'required'  => ':Attribute harus diisi.',
        ]);

        $credentials = $request->only('email','password');
        $remember_me = $request->has('remember_me') ? true : false;
        if(Auth::attempt($credentials, $remember_me)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('loginError', 'Login gagal!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
