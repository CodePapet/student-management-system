@extends('layouts.app')
@section('title', 'Courses')
@section('content')
@php $u = auth()->user(); $heading = $u->hasRole('lecturer') ? 'My courses' : ($u->hasRole('student') ? 'Available courses' : 'Courses'); @endphp
<div class="page-head">
    <div><h1>{{ $heading }}</h1><p class="muted mb-0">{{ $courses->total() }} {{ \Illuminate\Support\Str::plural('course', $courses->total()) }}</p></div>
    @can('create courses')
        <a href="{{ route('courses.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add course</a>
    @endcan
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Code</th><th>Course</th><th>Lecturer</th><th>Credits</th><th></th></tr></thead>
            <tbody>
            @forelse ($courses as $c)
                <tr>
                    <td class="fw-semibold">{{ $c->code }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->lecturer?->name ?? 'Not assigned' }}</td>
                    <td>{{ $c->credit_units }}</td>
                
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('courses.show', $c) }}">Open</a>
                        @can('register courses')
                            @if (in_array($c->id, $registeredIds))
                                <span class="badge text-bg-success">Registered</span>
                            @else
                                <form class="d-inline" method="POST" action="{{ route('courses.register', $c) }}">@csrf
                                    <button class="btn btn-sm btn-brand">Register</button>
                                </form>
                            @endif
                        @endcan
                        @can('edit courses')<a class="btn btn-sm btn-outline-secondary" href="{{ route('courses.edit', $c) }}">Edit</a>@endcan
                        @can('delete courses')
                            <form class="d-inline" method="POST" action="{{ route('courses.destroy', $c) }}" onsubmit="return confirm('Delete {{ $c->code }}? Its registrations will be removed too.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty"><i class="bi bi-journal"></i>No courses to show yet.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($courses->hasPages())<div class="panel-body pt-3">{{ $courses->links() }}</div>@endif
</div>
@endsection
