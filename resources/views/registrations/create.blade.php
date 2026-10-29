@extends('layouts.app')
@section('title', 'New registration')
@section('content')
<div class="page-head"><div><h1>New registration</h1><p class="muted mb-0">Duplicate registrations and full courses are blocked.</p></div></div>
<div class="panel"><div class="panel-body">
    <form method="POST" action="{{ route('registrations.store') }}" novalidate>
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="student_id">Student</label>
                <select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                    <option value="">Choose a student</option>
                    @foreach ($students as $s)
                        <option value="{{ $s->id }}" @selected(old('student_id') == $s->id)>{{ $s->full_name }} ({{ $s->student_number }})</option>
                    @endforeach
                </select>
                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="course_id">Course</label>
                <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                    <option value="">Choose a course</option>
                    @foreach ($courses as $c)
                        <option value="{{ $c->id }}" @selected(old('course_id') == $c->id)>{{ $c->code }} {{ $c->name }}</option>
                    @endforeach
                </select>
                @error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-brand">Register student</button>
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
