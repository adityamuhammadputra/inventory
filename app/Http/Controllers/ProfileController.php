<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        logActivities('View Profile page');
        $data = Log::where('user_id', userId())->orderBy('created_at', 'desc')->paginate(20);
        return view('profile.index', compact('data'));
    }

    public function update(Request $request, User $profile)
    {
        logActivities('Update Profile Id ' . $profile->id);
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->notes = $request->notes;
        $profile->password = Hash::make($request->password);
        $profile->save();

        return redirect()->back();
    }
}
