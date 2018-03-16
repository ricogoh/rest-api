<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $todos = Auth::user()->todos()->get();
        return response()->json(['success' => true,'result' => $todos]);
    }
     
    public function show($id)
    {
        if ($todo = Todo::find($id)) {
            return response()->json(['success' => true, 'todo' => $todo]);
        } else {
            return response()->json(['success' => false]);
        }
    }
 
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);
            
        if ($todo = Auth::user()->todos()->create($validator)) {
            return response()->json(['success' => true, 'todo' => $todo]);
        } else {
            return response()->json(['success' => false]);
        }
    }
 
    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'name' => 'filled',
            'description' => 'filled',
            'category' => 'filled'
         ]);

        $todo = Todo::find($id);

        if ($todo->fill($validator)->save()) {
            return response()->json(['success' => true, 'todo' => $todo]);
        }
        return response()->json(['status' => 'failed']);
    }
 
    public function destroy($id)
    {
        if (Todo::find($id)->user->id !== Auth::user()->id) {
            return response()->json(['success' => false]);
        }

        if (Todo::destroy($id)) {
            return response()->json(['success' => true, 'message' => 'Successful deleted todo id '.$id]);
        }
    }
}
