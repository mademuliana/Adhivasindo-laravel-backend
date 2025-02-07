<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function studentProfile()
    {
        $user = User::with('students')->find(Auth::id());
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password'] ?? 'password123');

        $user = User::create($validatedData);
        return response()->json(['message' => 'User registered successfully!', 'User' => $user], 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password'] ?? 'password123');

        $user->update($validatedData);
        return response()->json(['message' => 'User updated successfully!', 'User' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully!']);
    }
}
