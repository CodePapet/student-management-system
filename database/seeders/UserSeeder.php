<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $admin = User::firstOrCreate(
            ['email' => 'admin@mubs.ac.ug'],
            ['name' => 'System Administrator', 'password' => $password]
        );
        $admin->syncRoles('admin');

        $lecturers = [
            ['Dr. Grace Nakato', 'lecturer1@mubs.ac.ug'],
            ['Mr. Peter Okello', 'lecturer2@mubs.ac.ug'],
        ];
        foreach ($lecturers as [$name, $email]) {
            User::firstOrCreate(['email' => $email], ['name' => $name, 'password' => $password])
                ->syncRoles('lecturer');
        }

        $students = [
            ['Aisha', 'Namukasa', 'S2026-001', 1],
            ['Brian', 'Ssemwogerere', 'S2026-002', 2],
            ['Catherine', 'Atim', 'S2026-003', 3],
            ['David', 'Mugisha', 'S2026-004', 3],
            ['Esther', 'Nankya', 'S2026-005', 3],
            ['Felix', 'Opio', 'S2026-006', 2],
        ];
        foreach ($students as $i => [$first, $last, $number, $year]) {
            $email = 'student'.($i + 1).'@mubs.ac.ug';
            $user = User::firstOrCreate(['email' => $email], ['name' => "$first $last", 'password' => $password]);
            $user->syncRoles('student');

            Student::firstOrCreate(['student_number' => $number], [
                'user_id' => $user->id,
                'first_name' => $first,
                'last_name' => $last,
                'email' => $email,
                'phone' => '07010000'.str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'programme' => 'Bachelor of Business Computing',
                'year_of_study' => $year,
            ]);
        }
    }
}
