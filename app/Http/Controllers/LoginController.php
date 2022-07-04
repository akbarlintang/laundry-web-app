<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.user-pages.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard')
                        ->withSuccess('Signed in');
        }

        return redirect("admin/login")->withErrors(['salah'=>'Username atau password salah!']);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }

        return redirect("admin/login")->withErrors('You are not allowed to access');
    }

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();

        $request->session()->flash('logout', true);

        return Redirect('admin/login');
    }
}
