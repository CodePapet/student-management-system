@extends('layouts.app')
@section('title', 'Access denied')

@section('content')
<div class="panel"><div class="empty">
    <i class="bi bi-shield-lock"></i>
    <h2 class="h4 text-dark">You do not have access to this page</h2>
    <p>{{ $exception->getMessage() ?: 'Your role does not allow this action.' }}</p>
    <a href="{{ route('dashboard') }}" class="btn btn-brand">Back to dashboard</a>
</div></div>
@endsection
