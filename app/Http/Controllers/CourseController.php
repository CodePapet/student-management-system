<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Lecturers only see courses assigned to them; admins and students see all.
        $courses = Course::with('lecturer')->withCount('students')
            ->when($user->hasRole('lecturer'), fn ($q) => $q->where('lecturer_id', $user->id))
            ->orderBy('code')->paginate(10);

        $registeredIds = $user->student
            ? $user->student->courses()->pluck('courses.id')->all()
            : [];

        return view('courses.index', compact('courses', 'registeredIds'));
    }

    public function create()
    {
        return view('courses.create', ['lecturers' => $this->lecturers()]);
    }

    public function store(Request $request)
    {
        Course::create($request->validate($this->rules()));

        return redirect()->route('courses.index')->with('success', 'Course created.');
    }

    public function show(Course $course)
    {
        $user = auth()->user();

        // A lecturer must not open someone else's course.
        abort_if(
            $user->hasRole('lecturer') && $course->lecturer_id !== $user->id,
            403,
            'This course is not assigned to you.'
        );

        $course->load('lecturer');
        $students = $user->hasAnyRole(['admin', 'lecturer'])
            ? $course->students()->orderBy('last_name')->get()
            : collect();
        $registered = $user->student
            ? $user->student->courses()->where('courses.id', $course->id)->exists()
            : false;

        return view('courses.show', compact('course', 'students', 'registered'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', ['course' => $course, 'lecturers' => $this->lecturers()]);
    }

    public function update(Request $request, Course $course)
    {
        $course->update($request->validate($this->rules($course)));

        return redirect()->route('courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted.');
    }

    private function lecturers()
    {
        return User::role('lecturer')->orderBy('name')->get();
    }

    private function rules(?Course $course = null): array
    {
        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('courses')->ignore($course)],
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'credit_units' => 'required|integer|between:1,10',
            'lecturer_id' => 'nullable|exists:users,id',
        ];
    }
}
