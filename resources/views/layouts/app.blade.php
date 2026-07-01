<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SeaMark URL Shortner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .top-navbar {
            background-color: #fff;
            border-bottom: 2px solid #ff9800;
        }
        .brand-logo {
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .brand-logo span {
            background: #ff9800;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-right: 10px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg top-navbar px-4 py-3 mb-4 shadow-sm">
        <div class="container-fluid max-w-7xl">
            <a class="brand-logo" href="{{ route('dashboard') }}">
                <span>&lt;URL&gt;</span> Dashboard
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 text-muted">{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-dark text-decoration-none p-0">Logout &rarr;</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container max-w-7xl">
        {{ $slot }}
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
