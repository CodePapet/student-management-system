<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::withCount('courses')
            ->when($request->q, function ($query, $term) {
                $query->where(fn ($w) => $w->where('first_name', 'like', "%$term%")
                    ->orWhere('last_name', 'like', "%$term%")
                    ->orWhere('student_number', 'like', "%$term%")
                    ->orWhere('email', 'like', "%$term%"));
            })
            ->orderBy('last_name')->paginate(10)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['first_name'].' '.$data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('student');
            Student::create($data + ['user_id' => $user->id]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student added. Their sign-in password is "password" until changed.');
    }

    public function show(Student $student)
    {
        $student->load('courses.lecturer');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate($this->rules($student));

        DB::transaction(function () use ($data, $student) {
            $student->update($data);
            $student->user?->update([
                'name' => $data['first_name'].' '.$data['last_name'],
                'email' => $data['email'],
            ]);
        });

        return redirect()->route('students.show', $student)->with('success', 'Student details updated.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            $user?->delete();
        });

        return redirect()->route('students.index')->with('success', 'Student and their registrations were removed.');
    }

    private function rules(?Student $student = null): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'student_number' => ['required', 'string', 'max:30', Rule::unique('students')->ignore($student)],
            'email' => [
                'required', 'email', 'max:150',
                Rule::unique('students')->ignore($student),
                Rule::unique('users', 'email')->ignore($student?->user_id),
            ],
            'phone' => 'nullable|string|max:20',
            'programme' => 'required|string|max:150',
            'year_of_study' => 'required|integer|between:1,5',
        ];
    }
}
