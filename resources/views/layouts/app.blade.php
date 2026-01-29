<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Portal Berita Keuangan Terpercaya') - FinanceNews</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita terkini seputar saham, kripto, dan ekonomi makro.')">
    <meta name="keywords" content="@yield('meta_keywords', 'berita keuangan, saham, investasi, ihsg, kripto')">
    <meta name="author" content="FinanceNews Team">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'FinanceNews - Portal Berita Keuangan')">
    <meta property="og:description" content="@yield('meta_description', 'Update berita ekonomi terkini.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/logo/logo.PNG'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('meta_description')">
    <meta name="twitter:image" content="@yield('og_image')">

    <link rel="icon" href="{{ asset('assets/logo/logo.PNG') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    @stack('schema')

    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            font-family: 'Helvetica', sans-serif;
        }

        .news-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .news-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .category-badge {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('assets/logo/logo.PNG') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2 bg-white rounded-circle p-1">
                <span class="fs-3 fw-bold" style="font-family: 'Helvetica', sans-serif;">BREEDING FUND</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto font-sans-serif fw-semibold">
                    <li class="nav-item"><a class="nav-link active" href="/">News</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5 flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Breeding Fund.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>