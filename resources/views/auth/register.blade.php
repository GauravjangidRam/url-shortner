<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - URL Shortner</title>
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
            URL Shortner
        </div>
        <div class="login-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a class="text-decoration-none small" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
