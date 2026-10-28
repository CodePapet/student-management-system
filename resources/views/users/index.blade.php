@extends('layouts.app')
@section('title', 'User access')
@section('content')
<div class="page-head"><div><h1>User access</h1><p class="muted mb-0">Add administrators and lecturers, and change their roles.</p></div></div>
<div class="row g-3">
    <div class="col-xl-8">
        <div class="panel">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($users as $u)
                        @php $role = $u->getRoleNames()->first(); @endphp
                        <tr>
                            <td class="fw-semibold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if ($role === 'student' || $u->is(auth()->user()))
                                    <span class="badge text-bg-light border">{{ ucfirst($role) }}</span>
                                @else
                                    <form method="POST" action="{{ route('users.role', $u) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" class="form-select form-select-sm" style="width:130px" onchange="this.form.submit()">
                                            <option value="admin" @selected($role === 'admin')>Admin</option>
                                            <option value="lecturer" @selected($role === 'lecturer')>Lecturer</option>
                                        </select>
                                    </form>
                                @endif
                            </td>
                            <td class="text-end">
                                @unless ($role === 'student' || $u->is(auth()->user()))
                                    <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Delete {{ $u->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())<div class="panel-body pt-3">{{ $users->links() }}</div>@endif
        </div>
    </div>
    <div class="col-xl-4">
        <div class="panel panel-body">
            <h2 class="h5">Add a user</h2>
            <form method="POST" action="{{ route('users.store') }}" novalidate>
                @csrf
                <div class="mb-3"><label class="form-label" for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" class="form-control" required></div>
                <div class="mb-3"><label class="form-label" for="u_email">Email</label><input id="u_email" type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                <div class="mb-3"><label class="form-label" for="u_password">Password</label><input id="u_password" type="password" name="password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label" for="u_role">Role</label>
                    <select id="u_role" name="role" class="form-select"><option value="lecturer">Lecturer</option><option value="admin">Admin</option></select></div>
                <button class="btn btn-brand w-100">Add user</button>
            </form>
        </div>
    </div>
</div>
@endsection
