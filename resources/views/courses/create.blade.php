@extends('layouts.app')
@section('title', 'Add course')
@section('content')
<div class="page-head"><div><h1>Add course</h1></div></div>
<div class="panel"><div class="panel-body">
    <form method="POST" action="{{ route('courses.store') }}" novalidate>@csrf @include('courses._form')</form>
</div></div>
@endsection
