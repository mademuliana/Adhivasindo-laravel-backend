<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudentDataService
{
    protected $url;

    public function __construct()
    {
        $this->url = config('services.student_datas.url');
    }

    public function fetchStudentData()
    {
        try {
            $response = Http::get($this->url)->throw();

            $data = $response->json();

            if (!isset($data['DATA']) || empty($data['DATA'])) {
                throw new \Exception("Invalid data format.");
            }

            $datas = explode("\n", trim($data['DATA']));
            $students = [];

            // Extract the header row and map column positions
            $headers = explode('|', array_shift($datas)); // Get the first row as header

            $headerMap = array_flip($headers); // Flip keys and values to get index positions

            foreach ($datas as $data) {
                $values = explode('|', $data);

                // Ensure we have expected columns
                if (!isset($headerMap['NIM'], $headerMap['YMD'], $headerMap['NAMA'])) {
                    throw new \Exception("Missing expected columns.");
                }

                $students[] = [
                    'nim'  => $values[$headerMap['NIM']],
                    'ymd'  => $values[$headerMap['YMD']],
                    'nama' => $values[$headerMap['NAMA']],
                ];
            }

            return $students;
        } catch (\Exception $e) {
            Log::error("Error fetching student data: " . $e->getMessage());
            return [];
        }
    }

}
