<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentHelper
{
    public static function createStudentWithUser(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $username = str_replace(' ', '.', $data['nama']);
                $email = strtolower($username . '@student.com');

                $user = User::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                ]);

                $student = Student::create([
                    'user_id' => $user->id,
                    'nama' => $data['nama'],
                    'nim' => $data['nim'],
                    'ymd' => $data['ymd'],
                ]);

                return ['user' => $user, 'student' => $student];
            });
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
