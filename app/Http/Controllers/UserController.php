<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'create']]);
    }

    public function index()
    {
        return ['count' => User::count()];
    }
    
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return ['success' => false, 'error' =>'User not found.'];
        }

        $user->todos;

        return ['success' => true, 'user' => $user];
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:64'
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return ['success' => true, 'user' => $user];
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'filled',
            'password' => 'filled|min:4|max:64'
        ]);
            
        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        
        if (Auth::user()->id !== (int) $id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($id);
        $user->name = $request->input('name') ?? $user->name;
        $user->email = $request->input('email') ?? $user->email;
        $user->password = !empty($request->input('password')) ? Hash::make($request->input('password')) : $user->password;
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        return 'delete' . $id;
    }
}
