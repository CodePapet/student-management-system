@extends('layouts.app')
@section('title', 'Registrations')
@section('content')
<div class="page-head">
    <div><h1>{{ $isAdmin ? 'Registrations' : 'My registrations' }}</h1><p class="muted mb-0">{{ $registrations->total() }} on record</p></div>
    @can('manage registrations')
        <a href="{{ route('registrations.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> New registration</a>
    @else
        <a href="{{ route('courses.index') }}" class="btn btn-brand">Browse courses</a>
    @endcan
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr>@if ($isAdmin)<th>Student</th>@endif<th>Course</th><th>Semester</th><th>Registered</th><th></th></tr></thead>
            <tbody>
            @forelse ($registrations as $r)
                <tr>
                    @if ($isAdmin)<td>{{ $r->student->full_name }}<div class="muted small">{{ $r->student->student_number }}</div></td>@endif
                    <td><span class="fw-semibold">{{ $r->course->code }}</span> {{ $r->course->name }}</td>
                    <td>{{ $r->semester }}</td>
                    <td>{{ $r->registered_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <form method="POST" action="{{ route('registrations.destroy', $r) }}" onsubmit="return confirm('Remove this registration?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">{{ $isAdmin ? 'Remove' : 'Drop course' }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="empty"><i class="bi bi-clipboard"></i>No registrations yet.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($registrations->hasPages())<div class="panel-body pt-3">{{ $registrations->links() }}</div>@endif
</div>
@endsection
