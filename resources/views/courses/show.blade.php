@extends('layouts.app')
@section('title', 'Course details')
@section('content')
<div class="page-head">
    <div><h1>{{ $course->code }}: {{ $course->name }}</h1>
        <p class="muted mb-0">{{ $course->credit_units }} credit units, taught by {{ $course->lecturer?->name ?? 'a lecturer to be assigned' }}</p></div>
    <div class="d-flex gap-2">
        @can('register courses')
            @if ($registered)
                <span class="badge text-bg-success align-self-center p-2">You are registered</span>
            @else
                <form method="POST" action="{{ route('courses.register', $course) }}">@csrf<button class="btn btn-brand">Register for this course</button></form>
            @endif
        @endcan
        @can('edit courses')<a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-secondary">Edit</a>@endcan
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="panel panel-body mb-3">
    <h2 class="h6">About this course</h2>
    <p class="mb-0">{{ $course->description ?: 'No description has been added.' }}</p>
</div>

@if (auth()->user()->hasAnyRole(['admin', 'lecturer']))
<div class="panel">
    <div class="panel-body pb-2"><h2 class="h5 mb-0">Registered students ({{ $students->count() }} of {{ $course->capacity }})</h2></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Number</th><th>Name</th><th>Email</th><th>Year</th><th>Registered</th></tr></thead>
            <tbody>
            @forelse ($students as $s)
                <tr><td class="fw-semibold">{{ $s->student_number }}</td><td>{{ $s->full_name }}</td><td>{{ $s->email }}</td><td>{{ $s->year_of_study }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($s->pivot->registered_at)->format('d M Y') }}</td></tr>
            @empty
                <tr><td colspan="5"><div class="empty">No students have registered yet.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
