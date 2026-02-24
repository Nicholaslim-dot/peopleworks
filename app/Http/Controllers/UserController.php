<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('register', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|unique:users',
            'password' => 'required|min:6',
            'user_name' => 'required',
            'branch' => 'required',
            'user_level' => 'required|in:Admin,Manager,CE,Account,Guest',
        ]);

        User::create([
            'user_id' => $validated['user_id'],
            'password' => Hash::make($validated['password']),
            'user_name' => $validated['user_name'],
            'branch' => $validated['branch'],
            'user_level' => $validated['user_level'],
        ]);

        return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'branch' => 'required',
            'user_level' => 'required|in:Admin,Manager,CE,Account,Guest',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
