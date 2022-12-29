<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        return view('managers.index', [
            'employees' => User::visibleTo(Auth::user())->get()
        ]);
    }
}
