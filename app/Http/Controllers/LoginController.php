<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_emailactive) {
                return redirect()->route('dashboard');
            }
            Auth::logout();
            return back()->with('error', 'User Is Not Active');
        }

        return back()->with('error', 'Incorrect Details Entered');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
