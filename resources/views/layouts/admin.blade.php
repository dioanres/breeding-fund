<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS FinanceNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-radius: 8px;}
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3 text-white" style="width: 260px;">
            <div class="d-flex align-items-center mb-4 ps-2">
                <i class="bi bi-briefcase-fill fs-3 text-warning me-2"></i>
                <span class="fs-4 fw-bold">CMS Admin</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="bi bi-grid me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                   <a href="{{ route('admin.posts.index') }}" class="nav-link"><i class="bi bi-newspaper me-2"></i> Kelola Berita</a>
                </li>
                <li class="nav-item mt-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 mt-5"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>

        <main class="flex-grow-1 p-4">
            <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-3 shadow-sm">
                <h4 class="mb-0 fw-bold">@yield('page_title')</h4>
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="35">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span>
                </div>
            </header>

            @yield('content')
        </main>
    </div>
@stack('scripts')
</body>
</html>