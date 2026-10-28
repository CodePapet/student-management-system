@extends('layouts.app')
@section('title', 'Edit course')
@section('content')
<div class="page-head"><div><h1>Edit {{ $course->code }}</h1></div></div>
<div class="panel"><div class="panel-body">
    <form method="POST" action="{{ route('courses.update', $course) }}" novalidate>@csrf @method('PUT') @include('courses._form')</form>
</div></div>
@endsection
