<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.work-orders', [
            'workorders' => WorkOrder::where('created_by',Auth::id())->get() 
        ]);
    }
    public function create()
    {
        return view('customers.create');
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required|max:255|min:3',
            'last_name' => 'required|max:255|min:3',
            'email' => 'required|unique:users'
        ]);

        $attributes += [
            'role_id' => Role::CUSTOMER,
            'created_by' => Role::CUSTOMER,
            'password' => Hash::make($request['password']),
            'email_status' => true
        ];

        User::create($attributes);

        return redirect()->route('login')->with('success', 'Your Account has been created Successfully Please Login');
    }
}
