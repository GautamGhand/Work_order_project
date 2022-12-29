<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::with('role')->paginate(10),
        ]);
    }
    public function create()
    {
        return view('users.create', [
            'roles' => Role::manager()->get()
        ]);
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required|max:255|string|alpha',
            'last_name' => 'required|max:255|string|alpha',
            'email' => 'required|email:rfc,dns',
            'role_id' => ['required',
                            Rule::in(Role::manager()->pluck('id'))]
        ]);

        $attributes += [
            'created_by' => Role::ADMIN
        ];

        $user = User::create($attributes);

        Notification::send($user, new SetPasswordNotification(Auth::user()));

        return redirect()->route('users')->with('success', 'User Created Successfully');

    }
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'managers' => User::manager()->get()
        ]);
    }
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'first_name' => 'required|max:255|string|alpha',
            'last_name' => 'required|max:255|string|alpha',
            'manager_id' => ['required',
                            Rule::in(User::manager()->pluck('id'))]
        ]);

        $attributes += [
            'created_by' => $request['manager_id']
        ];

        $user->update($attributes);

        return redirect()->route('users')->with('success', 'User Updated Successfully');
    }
}
