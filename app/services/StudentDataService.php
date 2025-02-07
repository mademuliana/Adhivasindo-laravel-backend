<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            $headers = explode('|', array_shift($datas));
            $headerMap = array_flip($headers);

            if (!isset($headerMap['NIM'], $headerMap['YMD'], $headerMap['NAMA'])) {
                throw new \Exception("Missing expected columns.");
            }

            $batches = array_chunk($datas, 100);
            $anyNewRecords = false;

            foreach ($batches as $batch) {
                if ($this->processBatch($batch, $headerMap)) {
                    $anyNewRecords = true;
                }
            }

            return $anyNewRecords ? true : null;
        } catch (\Exception $e) {
            Log::error("Error fetching student data: " . $e->getMessage());
            return null;
        }
    }

    private function processBatch(array $batch, array $headerMap)
    {
        try {
            DB::beginTransaction();
            $students = [];
            $existingRecords = 0;

            foreach ($batch as $data) {
                $values = explode('|', $data);

                $nim  = $values[$headerMap['NIM']] ?? null;
                $ymd  = $values[$headerMap['YMD']] ?? null;
                $nama = $values[$headerMap['NAMA']] ?? null;

                if (!$nim || !$ymd || !$nama || !ctype_digit($nim) || !$this->isValidDate($ymd)) {
                    throw new \Exception("Malformed or invalid row found.");
                }

                $exists = DB::table('students')->where(compact('nim', 'ymd', 'nama'))->exists();

                if (!$exists) {
                    $students[] = compact('nim', 'ymd', 'nama');
                } else {
                    $existingRecords++;
                }
            }

            if (!empty($students)) {
                DB::table('students')->insert($students);
                DB::commit();
                return true;
            } else {
                DB::rollback();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Batch failed: " . $e->getMessage());
            return false;
        }
    }

    private function isValidDate($date)
    {
        return preg_match('/^\d{8}$/', $date);
    }

}
