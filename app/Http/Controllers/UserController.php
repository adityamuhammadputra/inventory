<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        logActivities("View User page");
        $users = User::get();
        return view('user.index', compact('users'));
    }
}
