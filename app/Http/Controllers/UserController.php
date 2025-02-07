<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStudentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\StudentHelper;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return response()->json($users);
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

    public function createStudent(UserStudentRequest $request)
    {
        $result = StudentHelper::createStudentWithUser($request->validated());

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json([
            'message' => 'Student and user created successfully!',
            'user' => $result['user'],
            'student' => $result['student'],
        ], 201);
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
