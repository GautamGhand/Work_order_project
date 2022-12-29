<?php

namespace App\Http\Controllers;

use App\Models\ManagerEmployee;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    public function create()
    {
        return view('users.create-employee', [
            'managers' => User::manager()->get()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required|max:255|string|alpha',
            'last_name' => 'required|max:255|string|alpha',
            'email' => 'required|email:rfc,dns',
            'manager_id' => ['required',
                        Rule::in(User::manager()->pluck('id'))]
        ]);

        $attributes += [
            'role_id' => Role::EMPLOYEE,
            'created_by' => $attributes['manager_id']
        ];

        $user = User::create($attributes);

        Notification::send($user, new SetPasswordNotification(Auth::user()));

        return back()->with('success', 'User Created Successfully');
    }
}
