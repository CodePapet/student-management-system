@extends('layouts.app')
@section('title', 'Add student')
@section('content')
<div class="page-head"><div><h1>Add student</h1><p class="muted mb-0">A sign-in account is created automatically.</p></div></div>
<div class="panel"><div class="panel-body">
    <form method="POST" action="{{ route('students.store') }}" novalidate>
        @csrf
        @include('students._form')
    </form>
</div></div>
@endsection
