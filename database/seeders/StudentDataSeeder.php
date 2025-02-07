<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Services\StudentDataService;

class StudentDataSeeder extends Seeder
{
    protected $studentDataService;

    public function __construct(StudentDataService $studentDataService)
    {
        $this->studentDataService = $studentDataService;
    }

    public function run()
    {
        $students = $this->studentDataService->fetchStudentData();

        if (empty($students)) {
            $this->command->error("No student data to seed.");
            return;
        }

        foreach ($students as $student) {
            Student::create($student);
        }

        $this->command->info("Student data seeded successfully.");
    }
}
