<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\Matcher\HasKey;

class PasswordSetController extends Controller
{
    function index(User $user)
    {
        return view('users.set-password', [
            'user' => $user
          ]);
    }

    function setpassword(Request $request,User $user)
    {

        $attributes=$request->validate([
            'password' => 'required|min:8',
            'cpassword' => ['required',
                             'min:8',
                            'same:password'
            ]
        ]);

        
        if($user->password==null)
        {
            if($user->update([
                'password' => Hash::make($attributes['password']),
                'email_status' => true
                ]))
            {
                $login=new LoginController();
                $page=$login->login($request); 
                
               return redirect($page->getTargetUrl());
                
            }
        }
            return back()->with('success', 'You Have Set Your Password');

    }
}
