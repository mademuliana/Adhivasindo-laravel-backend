<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

app()->singleton(Schedule::class, function ($app) {
    $schedule = new Schedule();

    $schedule->call(function () {
        $message = "StudentDataService executed at " . now();

        // Log the message
        \Log::info($message);

        // Display the message in the console
        echo $message . PHP_EOL;
        app(\App\Services\StudentDataService::class)->fetchStudentData();
    })->everyMinute();

    return $schedule;
});
