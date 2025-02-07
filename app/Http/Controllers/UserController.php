<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $Users = User::all();
        return response()->json($Users);
    }
    public function studentProfile()
    {
        $Users = User::with('students')->find(Auth::id());
        return response()->json($Users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'role' => 'required|in:student,admin',
            'email' => 'required|email|unique:users',
            'password' => 'nullable|string|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password'] ?? 'password123');

        $user = User::create($validatedData);
        return response()->json(['message' => 'User registered successfully!', 'User' => $user], 201);
    }

    public function show(User $User)
    {
        return response()->json($User);
    }

    public function update(Request $request, User $User)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'role' => 'required|in:student,admin',
            'email' => 'required|email|unique:users',
            'password' => 'nullable|string|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password'] ?? 'password123');

        $User->update($validatedData);

        return response()->json(['message' => 'User updated successfully!', 'User' => $User]);
    }

    public function destroy(User $User)
    {
        $User->delete();
        return response()->json(['message' => 'User deleted successfully!']);
    }
}
