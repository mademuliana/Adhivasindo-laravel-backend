<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $result = $this->studentDataService->fetchStudentData();

        if ($result === null) {
            $this->command->error("No new student data to seed.");
            return;
        }

        $this->command->info("Student data seeded successfully.");
    }
}
