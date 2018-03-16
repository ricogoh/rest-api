<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
 
        $user = User::where('email', $request->input('email'))->first();

        if (Crypt::encrypt($request->input('password'), $user->password)) {
            $api_token = str_random(190);
            $user->fill(['api_token' => $api_token])->save();
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false], 401);
        }
    }

    public function logout(Request $request)
    {
        if ($request->header('Authorization')) {
            $key = explode(' ', $request->header('Authorization'));

            if ($key[0] !== 'Bearer') {
                return response()->json(['success' => false], 401);
            }
            
            $user = User::where('api_token', $key[1])->first();
            $user->fill(['api_token' => null])->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
