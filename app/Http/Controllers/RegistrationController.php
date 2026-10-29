<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private const SEMESTER = 'Semester I 2026/2027';

    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');

        $registrations = $isAdmin
            ? Registration::with(['student', 'course'])->latest('registered_at')->paginate(10)
            : Registration::with('course.lecturer')
                ->where('student_id', $user->student?->id)   // students only ever see their own
                ->latest('registered_at')->paginate(10);

        return view('registrations.index', compact('registrations', 'isAdmin'));
    }

    public function create()
    {
        return view('registrations.create', [
            'students' => Student::orderBy('last_name')->get(),
            'courses' => Course::withCount('students')->orderBy('code')->get(),
        ]);
    }

    /** Admin registers any student for any course. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $error = $this->enroll(Student::findOrFail($data['student_id']), Course::findOrFail($data['course_id']));
        if ($error) {
            return back()->withInput()->with('error', $error);
        }

        return redirect()->route('registrations.index')->with('success', 'Registration saved.');
    }

    /** Student registers themselves for a course. */
    public function register(Course $course)
    {
        $student = auth()->user()->student;
        abort_if(! $student, 403, 'Your account has no student profile.');

        $error = $this->enroll($student, $course);

        return back()->with($error ? 'error' : 'success', $error ?? "You are now registered for {$course->code}.");
    }

    public function destroy(Registration $registration)
    {
        $user = auth()->user();

        // Admins may remove any registration; students only their own.
        abort_unless(
            $user->hasRole('admin') || $registration->student_id === $user->student?->id,
            403,
            'You can only manage your own registrations.'
        );

        $registration->delete();

        return back()->with('success', 'Registration removed.');
    }

    private function enroll(Student $student, Course $course): ?string
    {
        if (Registration::where('student_id', $student->id)->where('course_id', $course->id)->exists()) {
            return "{$student->full_name} is already registered for {$course->code}.";
        }
       

        Registration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'semester' => self::SEMESTER,
            'registered_at' => now(),
        ]);

        return null;
    }
}
