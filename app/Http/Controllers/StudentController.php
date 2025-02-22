<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::paginate(10);

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

    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());

        return response()->json(['message' => 'Student registered successfully!', 'student' => $student], 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return response()->json(['message' => 'Student updated successfully!', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully!']);
    }
}
