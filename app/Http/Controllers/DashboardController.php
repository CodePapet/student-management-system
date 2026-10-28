<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $role = 'admin';
            $stats = [
                ['Students', Student::count(), 'bi-people'],
                ['Courses', Course::count(), 'bi-journal-bookmark'],
                ['Registrations', Registration::count(), 'bi-clipboard-check'],
                ['System users', User::count(), 'bi-person-gear'],
            ];
            $items = Registration::with(['student', 'course'])->latest('registered_at')->take(6)->get();
        } elseif ($user->hasRole('lecturer')) {
            $role = 'lecturer';
            $items = $user->taughtCourses()->withCount('students')->orderBy('code')->get();
            $stats = [
                ['Assigned courses', $items->count(), 'bi-journal-bookmark'],
                ['Registered students', $items->sum('students_count'), 'bi-people'],
            ];
        } else {
            $role = 'student';
            $items = $user->student ? $user->student->courses()->with('lecturer')->get() : collect();
            $stats = [
                ['Available courses', Course::count(), 'bi-journal-bookmark'],
                ['My registrations', $items->count(), 'bi-clipboard-check'],
                ['Credit units', $items->sum('credit_units'), 'bi-award'],
            ];
        }

        return view('dashboard', compact('role', 'stats', 'items'));
    }
}
