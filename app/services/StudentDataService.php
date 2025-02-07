<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

            $batches = array_chunk($datas, 25);
            $anyNewRecords = false;

            foreach ($batches as $index => $batch) {
                echo "Processing batch " . ($index + 1) . "...\n";

                if ($this->processBatch($batch, $headerMap)) {
                    $anyNewRecords = true;
                }

                echo "Batch " . ($index + 1) . " processed.\n";
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
            $users = [];
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
                    $username = strtolower(str_replace(' ', '.', $nama));
                    $email = $username . '@student.com';
                    $password = Hash::make('password123');

                    $userId = DB::table('users')->insertGetId([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'role' => 'student',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $students[] = [
                        'user_id' => $userId,
                        'nim' => $nim,
                        'ymd' => $ymd,
                        'nama' => $nama,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    $existingRecords++;
                }
            }

            if (!empty($students)) {
                DB::table('students')->insert($students);
                DB::commit();
                echo "  ✔ Added " . count($students) . " new students.\n";
            } else {
                DB::rollback();
                echo "  ⚠ No new students added.\n";
            }

            echo "  ⚠ Skipped " . $existingRecords . " existing records.\n";

            return !empty($students);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Batch failed: " . $e->getMessage());
            echo "  ❌ Error processing batch: " . $e->getMessage() . "\n";
            return false;
        }
    }

    private function isValidDate($date)
    {
        return preg_match('/^\d{8}$/', $date);
    }
}
