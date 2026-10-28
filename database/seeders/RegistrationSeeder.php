<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $pairs = [
            'S2026-001' => ['BUC3131', 'BUC3132'],
            'S2026-002' => ['BUC3131', 'BUC3133', 'BUC3134'],
            'S2026-003' => ['BUC3131', 'BUC3132', 'BUC3135'],
            'S2026-004' => ['BUC3132', 'BUC3134'],
            'S2026-005' => ['BUC3131', 'BUC3135'],
            'S2026-006' => ['BUC3133'],
        ];

        foreach ($pairs as $number => $codes) {
            $student = Student::where('student_number', $number)->first();
            foreach ($codes as $code) {
                $course = Course::where('code', $code)->first();
                if ($student && $course) {
                    Registration::firstOrCreate(
                        ['student_id' => $student->id, 'course_id' => $course->id],
                        ['semester' => 'Semester I 2026/2027', 'registered_at' => now()]
                    );
                }
            }
        }
    }
}
