<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SeaMark URL Shortner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background: #fff;
            overflow: hidden;
        }
        .login-header {
            background-color: #ff9800;
            color: #fff;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }
        .login-header span {
            background: #fff;
            color: #ff9800;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-right: 10px;
        }
        .login-body {
            padding: 30px 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <span>&lt;URL&gt;</span> SeaMark URL Shortner
        </div>
        <div class="login-body">
            <div class="mb-4 text-sm text-muted small">
                {{ __('Directly reset your password below.') }}
            </div>

            <form method="POST" action="{{ route('password.update.direct') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none small text-primary fw-bold">Back to Login</a>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
