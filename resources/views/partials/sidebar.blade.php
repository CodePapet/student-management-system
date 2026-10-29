@php $u = auth()->user(); @endphp
<a href="{{ route('dashboard') }}" class="brand">
    <span class="brand-mark">S</span>
    <span>
        <span class="brand-name d-block">Student Management</span>
     
    </span>
</a>

<nav>
    <div class="nav-group">Overview</div>
    <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <div class="nav-group">Academics</div>
    @can('view students')
        <a class="side-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
            <i class="bi bi-people"></i> Students
        </a>
    @endcan
    @can('view courses')
        <a class="side-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
            <i class="bi bi-journal-bookmark"></i> Courses
        </a>
    @endcan
    @can('view assigned courses')
        <a class="side-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
            <i class="bi bi-journal-check"></i> My courses
        </a>
    @endcan
    @can('view available courses')
        <a class="side-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
            <i class="bi bi-journal-bookmark"></i> Available courses
        </a>
    @endcan
    @can('manage registrations')
        <a class="side-link {{ request()->routeIs('registrations.*') ? 'active' : '' }}" href="{{ route('registrations.index') }}">
            <i class="bi bi-clipboard-check"></i> Registrations
        </a>
    @endcan
    @can('view own registrations')
        <a class="side-link {{ request()->routeIs('registrations.*') ? 'active' : '' }}" href="{{ route('registrations.index') }}">
            <i class="bi bi-clipboard-check"></i> My registrations
        </a>
    @endcan

    @can('manage users')
        <div class="nav-group">Administration</div>
        <a class="side-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="bi bi-person-gear"></i> User access
        </a>
    @endcan
</nav>

<div class="side-user">
    <div class="name">{{ $u->name }}</div>
    <div class="role mb-2">{{ ucfirst($u->getRoleNames()->first() ?? 'No role') }}</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i> Sign out</button>
    </form>
</div>
