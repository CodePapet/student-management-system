<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Hanken Grotesk',system-ui,sans-serif; min-height:100vh; background:#f2f4f8; }
        h1,h2 { font-family:'Bricolage Grotesque',sans-serif; letter-spacing:-.01em; }
        .split { display:grid; grid-template-columns:1.05fr 1fr; min-height:100vh; }
        .hero { background:#10213f; color:#fff; padding:3rem; display:flex; flex-direction:column; justify-content:space-between; }
        .hero h1 { font-size:2.6rem; font-weight:700; max-width:16ch; line-height:1.08; }
        .mark { width:44px; height:44px; border-radius:12px; background:#d4a22f; color:#10213f; display:grid; place-items:center; font-weight:700; font-size:1.3rem; font-family:'Bricolage Grotesque',sans-serif; }
        .hero p { color:#a9b7d4; max-width:42ch; }
        .form-side { display:flex; align-items:center; justify-content:center; padding:2rem; }
        .card-login { width:100%; max-width:400px; }
        .btn-brand { background:#10213f; color:#fff; border:0; padding:.7rem; font-weight:500; }
        .btn-brand:hover { background:#1b3158; color:#fff; }
        .form-control:focus { border-color:#1b3158; box-shadow:0 0 0 .2rem rgba(27,49,88,.15); }
        .demo { font-size:.85rem; background:#fff; border:1px solid #e2e6ee; border-radius:10px; padding:.8rem 1rem; }
        @media (max-width:860px){ .split{grid-template-columns:1fr;} .hero{display:none;} }
    </style>
</head>
<body>
<div class="split">
    <section class="hero">
        <div class="mark">S</div>
        <div>
            <h1>Courses, students and registrations in one place.</h1>
            <p class="mt-3">Makerere University Business School. Sign in to manage records, view your courses or register for the semester.</p>
        </div>
        <small style="color:#7f8fb0">BUC3131 Advanced Web Application Development</small>
    </section>

    <section class="form-side">
        <div class="card-login">
            <h2 class="mb-1">Sign in</h2>
            <p class="text-secondary mb-4">Use your university account.</p>

            @if (session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Keep me signed in</label>
                </div>
                <button class="btn btn-brand w-100">Sign in</button>
            </form>

            <div class="demo mt-4">
                <strong>Demo accounts</strong> (password: <code>password</code>)<br>
                admin@mubs.ac.ug<br>lecturer1@mubs.ac.ug<br>student1@mubs.ac.ug
            </div>
        </div>
    </section>
</div>
</body>
</html>
