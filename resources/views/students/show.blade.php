@extends('layouts.app')
@section('title', 'Student profile')
@section('content')
<div class="page-head">
    <div><h1>{{ $student->full_name }}</h1><p class="muted mb-0">{{ $student->student_number }}, {{ $student->programme }}, Year {{ $student->year_of_study }}</p></div>
    <div class="d-flex gap-2">
        @can('edit students')<a href="{{ route('students.edit', $student) }}" class="btn btn-outline-secondary">Edit</a>@endcan
        <a href="{{ route('students.index') }}" class="btn btn-brand">All students</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="panel panel-body">
            <h2 class="h6">Contact</h2>
            <p class="mb-1"><i class="bi bi-envelope me-2"></i>{{ $student->email }}</p>
            <p class="mb-0"><i class="bi bi-telephone me-2"></i>{{ $student->phone ?: 'No phone on record' }}</p>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-body pb-2"><h2 class="h5 mb-0">Registered courses ({{ $student->courses->count() }})</h2></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Code</th><th>Course</th><th>Lecturer</th><th>Registered</th></tr></thead>
                    <tbody>
                    @forelse ($student->courses as $c)
                        <tr><td class="fw-semibold">{{ $c->code }}</td><td>{{ $c->name }}</td><td>{{ $c->lecturer?->name ?? 'Not assigned' }}</td><td>{{ \Illuminate\Support\Carbon::parse($c->pivot->registered_at)->format('d M Y') }}</td></tr>
                    @empty
                        <tr><td colspan="4"><div class="empty">This student has no registrations.</div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
