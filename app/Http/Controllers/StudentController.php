<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function search(Request $request)
    {
        $students = Student::search($request->only(['nim', 'nama', 'ymd']))->paginate(20);

        if ($students->isEmpty()) {
            return response()->json(['message' => 'No matching students found.'], 404);
        }

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:13|regex:/^[0-9]+$/',
            'ymd' => 'required|date',
        ]);

        $student = Student::create($request->all());

        return response()->json(['message' => 'Student registered successfully!', 'student' => $student], 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:13|regex:/^[0-9]+$/',
            'ymd' => 'required|date',
        ]);

        $student->update($request->all());

        return response()->json(['message' => 'Student updated successfully!', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully!']);
    }
}
