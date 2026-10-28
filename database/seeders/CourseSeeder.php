<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $l1 = User::where('email', 'lecturer1@mubs.ac.ug')->value('id');
        $l2 = User::where('email', 'lecturer2@mubs.ac.ug')->value('id');

        $courses = [
            ['BUC3131', 'Advanced Web Application Development', 'Building secure, database-driven web applications with Laravel.', 4, 60, $l1],
            ['BUC3132', 'Systems Analysis and Design', 'Modelling and designing business information systems.', 3, 60, $l2],
            ['BUC3133', 'Database Administration', 'Administering, tuning and securing relational databases.', 3, 40, $l1],
            ['BUC3134', 'Business Intelligence', 'Turning organisational data into decisions.', 3, 40, $l2],
            ['BUC3135', 'IT Project Management', 'Planning and delivering technology projects.', 3, 50, $l1],
        ];

        foreach ($courses as [$code, $name, $description, $credits, $capacity, $lecturer]) {
            Course::firstOrCreate(['code' => $code], [
                'name' => $name,
                'description' => $description,
                'credit_units' => $credits,
                'capacity' => $capacity,
                'lecturer_id' => $lecturer,
            ]);
        }
    }
}
