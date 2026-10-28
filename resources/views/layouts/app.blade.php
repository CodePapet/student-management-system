<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#10213f; --ink-2:#1b3158; --gold:#d4a22f; --paper:#f2f4f8; --line:#e2e6ee; --text:#1c2433; --muted:#667085; --side-w:264px; }
        body { font-family:'Hanken Grotesk',system-ui,sans-serif; background:var(--paper); color:var(--text); }
        h1,h2,h3,h4,.brand-name { font-family:'Bricolage Grotesque',system-ui,sans-serif; letter-spacing:-.01em; }
        .app { display:flex; min-height:100vh; }
        .sidebar { width:var(--side-w); background:var(--ink); color:#c9d3e6; position:fixed; inset:0 auto 0 0; display:flex; flex-direction:column; z-index:1040; transition:transform .2s ease; overflow-y:auto; }
        .brand { padding:1.5rem 1.4rem 1rem; display:flex; gap:.8rem; align-items:center; color:#fff; text-decoration:none; }
        .brand-mark { width:40px; height:40px; border-radius:11px; background:var(--gold); color:var(--ink); display:grid; place-items:center; font-weight:700; font-size:1.25rem; font-family:'Bricolage Grotesque',sans-serif; }
        .brand-name { font-size:1.05rem; font-weight:700; line-height:1.1; }
        .brand-sub { font-size:.78rem; color:#8c9cbf; }
        .nav-group { padding:1.2rem 1.4rem .4rem; font-size:.8rem; color:#7f8fb0; font-weight:600; }
        .side-link { display:flex; align-items:center; gap:.85rem; padding:.7rem 1.4rem; color:#c9d3e6; text-decoration:none; border-left:3px solid transparent; font-weight:500; }
        .side-link i { font-size:1.1rem; }
        .side-link:hover { background:var(--ink-2); color:#fff; }
        .side-link.active { background:var(--ink-2); color:#fff; border-left-color:var(--gold); }
        .side-user { margin-top:auto; padding:1rem 1.4rem; border-top:1px solid #243a64; }
        .side-user .name { color:#fff; font-weight:600; }
        .side-user .role { font-size:.8rem; color:#8c9cbf; }
        .main { margin-left:var(--side-w); flex:1; min-width:0; display:flex; flex-direction:column; }
        .topbar { background:#fff; border-bottom:1px solid var(--line); padding:.85rem 1.75rem; display:flex; align-items:center; gap:1rem; position:sticky; top:0; z-index:1020; }
        .topbar .page { font-family:'Bricolage Grotesque',sans-serif; font-weight:700; font-size:1.1rem; }
        .menu-btn { display:none; border:0; background:none; font-size:1.6rem; line-height:1; color:var(--ink); }
        .content { padding:1.75rem; flex:1; }
        .footer { padding:1rem 1.75rem; color:var(--muted); font-size:.85rem; border-top:1px solid var(--line); background:#fff; }
        .page-head { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1.4rem; }
        .page-head h1 { font-size:1.65rem; margin:0; font-weight:700; }
        .muted { color:var(--muted); }
        .panel { background:#fff; border:1px solid var(--line); border-radius:14px; }
        .panel-body { padding:1.4rem; }
        .stat { display:flex; gap:1rem; align-items:center; padding:1.2rem 1.3rem; }
        .stat .ico { width:46px; height:46px; border-radius:12px; background:#e8eefb; color:var(--ink-2); display:grid; place-items:center; font-size:1.35rem; }
        .stat .num { font-family:'Bricolage Grotesque',sans-serif; font-size:1.9rem; font-weight:700; line-height:1; }
        .btn-brand { background:var(--ink); color:#fff; border:0; font-weight:500; }
        .btn-brand:hover, .btn-brand:focus { background:var(--ink-2); color:#fff; }
        .table > :not(caption) > * > * { padding:.85rem 1.1rem; vertical-align:middle; }
        .table thead th { font-weight:600; font-size:.85rem; color:var(--muted); background:#f8f9fc; border-bottom:1px solid var(--line); }
        .form-label { font-weight:600; font-size:.9rem; }
        .form-control:focus, .form-select:focus { border-color:var(--ink-2); box-shadow:0 0 0 .2rem rgba(27,49,88,.15); }
        .empty { text-align:center; padding:3rem 1rem; color:var(--muted); }
        .empty i { font-size:2.2rem; display:block; margin-bottom:.5rem; }
        .scrim { display:none; }
        @media (max-width: 991px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:none; }
            .sidebar.open + .scrim { display:block; position:fixed; inset:0; background:rgba(8,16,33,.5); z-index:1030; }
            .main { margin-left:0; }
            .menu-btn { display:block; }
            .topbar, .content, .footer { padding-left:1rem; padding-right:1rem; }
        }
        @media (prefers-reduced-motion: reduce) { .sidebar { transition:none; } }
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar" id="sidebar">
        @include('partials.sidebar')
    </aside>
    <div class="scrim" id="scrim"></div>

    <div class="main">
        <header class="topbar">
            <button class="menu-btn" id="menuBtn" aria-label="Open navigation"><i class="bi bi-list"></i></button>
            <span class="page">@yield('title', 'Dashboard')</span>
            <span class="ms-auto muted d-none d-md-inline"><i class="bi bi-calendar3 me-1"></i>Semester I 2026/2027</span>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            &copy; {{ date('Y') }} Makerere University Business School. Student Management System, BUC3131 Coursework Two.
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sb = document.getElementById('sidebar');
    document.getElementById('menuBtn').addEventListener('click', () => sb.classList.toggle('open'));
    document.getElementById('scrim').addEventListener('click', () => sb.classList.remove('open'));
</script>
</body>
</html>
