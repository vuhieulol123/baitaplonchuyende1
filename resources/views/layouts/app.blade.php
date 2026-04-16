<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gym Store Pro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f6f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
        }

        .hero {
            background: linear-gradient(135deg, #111827, #1f2937);
            color: white;
            border-radius: 20px;
            padding: 60px 40px;
        }

        .product-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-card img {
            height: 240px;
            object-fit: cover;
        }

        .price-old {
            text-decoration: line-through;
            color: #888;
            font-size: 0.95rem;
        }

        .price-new {
            color: #dc3545;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .footer {
            background: #111827;
            color: #fff;
            padding: 40px 0;
            margin-top: 60px;
        }

        .banner-card {
            border-radius: 20px;
            overflow: hidden;
            min-height: 320px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
            display: flex;
            align-items: center;
            padding: 40px;
            color: white;
        }
    </style>
</head>
<body>
    @include('partials.header')

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>