@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1>Welcome back, {{ strtok(auth()->user()->name, ' ') }}</h1>
        <p class="muted mb-0">
            @if ($role === 'admin') Here is what is happening across the university.
            @elseif ($role === 'lecturer') Your assigned courses and their registered students.
            @else Your courses for this semester.
            @endif
        </p>
    </div>
</div>

<div class="row g-3 mb-4">
    @foreach ($stats as [$label, $value, $icon])
        <div class="col-sm-6 col-xl">
            <div class="panel stat">
                <div class="ico"><i class="bi {{ $icon }}"></i></div>
                <div><div class="num">{{ $value }}</div><div class="muted">{{ $label }}</div></div>
            </div>
        </div>
    @endforeach
</div>

<div class="panel">
    <div class="panel-body pb-2 d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">
            @if ($role === 'admin') Latest registrations @elseif ($role === 'lecturer') Assigned courses @else My registered courses @endif
        </h2>
        @if ($role === 'student')
            <a href="{{ route('courses.index') }}" class="btn btn-sm btn-brand">Browse courses</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            @if ($role === 'admin')
                <thead><tr><th>Student</th><th>Course</th><th>Registered</th></tr></thead>
                <tbody>
                @forelse ($items as $r)
                    <tr><td>{{ $r->student->full_name }}</td><td>{{ $r->course->code }} {{ $r->course->name }}</td><td>{{ $r->registered_at->format('d M Y') }}</td></tr>
                @empty
                    <tr><td colspan="3"><div class="empty"><i class="bi bi-inbox"></i>No registrations yet.</div></td></tr>
                @endforelse
                </tbody>
            @elseif ($role === 'lecturer')
                <thead><tr><th>Code</th><th>Course</th><th>Students</th><th></th></tr></thead>
                <tbody>
                @forelse ($items as $c)
                    <tr><td class="fw-semibold">{{ $c->code }}</td><td>{{ $c->name }}</td><td>{{ $c->students_count }}</td>
                        <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('courses.show', $c) }}">View students</a></td></tr>
                @empty
                    <tr><td colspan="4"><div class="empty"><i class="bi bi-inbox"></i>No courses are assigned to you yet.</div></td></tr>
                @endforelse
                </tbody>
            @else
                <thead><tr><th>Code</th><th>Course</th><th>Lecturer</th><th>Credits</th></tr></thead>
                <tbody>
                @forelse ($items as $c)
                    <tr><td class="fw-semibold">{{ $c->code }}</td><td>{{ $c->name }}</td><td>{{ $c->lecturer?->name ?? 'Not assigned' }}</td><td>{{ $c->credit_units }}</td></tr>
                @empty
                    <tr><td colspan="4"><div class="empty"><i class="bi bi-inbox"></i>You have not registered for any course yet.</div></td></tr>
                @endforelse
                </tbody>
            @endif
        </table>
    </div>
</div>
@endsection
