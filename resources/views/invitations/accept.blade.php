<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Invitation - URL Shortner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .invite-card {
            width: 100%;
            max-width: 420px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background: #fff;
            overflow: hidden;
        }
        .invite-header {
            background-color: #ff9800;
            color: #fff;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .invite-body {
            padding: 30px 20px;
        }
    </style>
</head>
<body>
    <div class="invite-card">
        <div class="invite-header">
            &lt;URL&gt; Complete Your Registration
        </div>
        <div class="invite-body">

            <p class="text-muted small mb-4">
                You've been invited as <strong>{{ $invitation->role }}</strong>.
                Your account will be created with the email: <strong>{{ $invitation->email }}</strong>
            </p>
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('invitations.register', $invitation->token) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email</label>
                    <input
                        type="email"
                        class="form-control bg-light"
                        value="{{ $invitation->email }}"
                        disabled
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">Create Account</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
