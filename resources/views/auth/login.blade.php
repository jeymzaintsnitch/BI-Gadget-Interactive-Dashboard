<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — GadgetBI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff; border-radius: 24px; padding: 48px 40px;
            width: 100%; max-width: 420px; box-shadow: 0 25px 50px rgba(0,0,0,.3);
        }
        .login-logo {
            width: 64px; height: 64px; background: #6366f1; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff; margin: 0 auto 24px;
        }
        .login-title   { font-size: 1.5rem; font-weight: 700; color: #1e293b; text-align: center; }
        .login-subtitle { font-size: .875rem; color: #64748b; text-align: center; margin-bottom: 32px; }
        .form-label    { font-size: .8rem; font-weight: 600; color: #374151; }
        .form-control  { border-radius: 10px; border-color: #e2e8f0; padding: 11px 14px; font-size: .9rem; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        .btn-login {
            background: #6366f1; color: #fff; border: none; border-radius: 12px;
            padding: 12px; font-size: .95rem; font-weight: 600; width: 100%;
            transition: background .2s;
        }
        .btn-login:hover { background: #4f46e5; }
        .demo-accounts { background: #f8fafc; border-radius: 12px; padding: 16px; margin-top: 24px; }
        .demo-accounts h6 { font-size: .75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px; }
        .demo-item { display: flex; justify-content: space-between; font-size: .78rem; color: #475569; padding: 3px 0; }
        .demo-role  { font-weight: 600; color: #6366f1; }
        .alert-danger { border-radius: 10px; font-size: .875rem; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-logo"><i class="bi bi-gear-wide-connected"></i></div>
    <div class="login-title">GadgetBI Dashboard</div>
    <div class="login-subtitle">Sales Analytics &amp; Management System</div>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            {{ $errors->first() }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="you@gadgetstore.com" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="demo-accounts">
        <h6>Demo Accounts (password: <code>password</code>)</h6>
        <div class="demo-item"><span class="demo-role">Admin</span>    <span>admin@gadgetstore.com</span></div>
        <div class="demo-item"><span class="demo-role">Staff</span>    <span>staff@gadgetstore.com</span></div>
    </div>
</div>
</body>
</html>
