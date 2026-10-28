@extends('layouts.app')
@section('title', 'Edit student')
@section('content')
<div class="page-head"><div><h1>Edit {{ $student->full_name }}</h1></div></div>
<div class="panel"><div class="panel-body">
    <form method="POST" action="{{ route('students.update', $student) }}" novalidate>
        @csrf @method('PUT')
        @include('students._form')
    </form>
</div></div>
@endsection
