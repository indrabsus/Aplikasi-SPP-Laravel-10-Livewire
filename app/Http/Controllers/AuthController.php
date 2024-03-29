<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('loginui');
    }
    public function login(Request $request)
    {
        $auth = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        
        

        if(Auth::attempt($auth)){
            Auth::user();
            return redirect()->route('index'.Auth::user()->level);
        }
        else {
            return redirect()->route('index');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index')->with('status', 'Anda berhasil logout');
    }
}
