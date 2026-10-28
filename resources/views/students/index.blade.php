@extends('layouts.app')
@section('title', 'Students')
@section('content')
<div class="page-head">
    <div><h1>Students</h1><p class="muted mb-0">{{ $students->total() }} on record</p></div>
    @can('create students')
        <a href="{{ route('students.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add student</a>
    @endcan
</div>

<div class="panel">
    <div class="panel-body pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by name, number or email"></div>
            <div class="col-auto"><button class="btn btn-outline-secondary">Search</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Number</th><th>Name</th><th>Email</th><th>Year</th><th>Courses</th><th></th></tr></thead>
            <tbody>
            @forelse ($students as $s)
                <tr>
                    <td class="fw-semibold">{{ $s->student_number }}</td>
                    <td>{{ $s->full_name }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->year_of_study }}</td>
                    <td><span class="badge text-bg-light border">{{ $s->courses_count }}</span></td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('students.show', $s) }}">View</a>
                        @can('edit students')<a class="btn btn-sm btn-outline-secondary" href="{{ route('students.edit', $s) }}">Edit</a>@endcan
                        @can('delete students')
                            <form class="d-inline" method="POST" action="{{ route('students.destroy', $s) }}" onsubmit="return confirm('Delete {{ $s->full_name }}? Their registrations will be removed too.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><i class="bi bi-people"></i>No students match. Add the first one to get started.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($students->hasPages())<div class="panel-body pt-3">{{ $students->links() }}</div>@endif
</div>
@endsection
