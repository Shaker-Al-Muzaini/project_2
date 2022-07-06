<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->except = ['login', 'register'];
        parent::__construct();
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['data' => 'wrong email or passwprd'], 422);
        }
        $token = $user->createToken('Auth Token')->accessToken;
        return  $token;
    }
    public function register(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::create(['email' => $request->email, 'password' => $request->password, 'name' => $request->name])->first();
        return  $user;
    }
}
