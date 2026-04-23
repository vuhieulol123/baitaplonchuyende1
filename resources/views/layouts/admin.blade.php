<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            background: #111827;
            color: #fff;
            padding: 24px 16px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
        }

        .admin-brand {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }

        .admin-sidebar a {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: 0.2s ease;
            font-weight: 600;
        }

        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: #1f2937;
            color: #fff;
        }

        .admin-content {
            margin-left: 260px;
            width: calc(100% - 260px);
        }

        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .admin-main {
            padding: 28px;
        }

        .admin-user-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-user-name {
            font-weight: 700;
            color: #111827;
        }

        .stat-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-brand">ADMIN</div>

            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                Báo cáo thống kê
            </a>

            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                Quản lý đơn hàng
            </a>

            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                Quản lý sản phẩm
            </a>

            <a href="{{ route('admin.promotions.index') }}" class="{{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                Chương trình khuyến mãi
            </a>

            <a href="{{ route('home') }}">
                Về trang user
            </a>
        </aside>

        <div class="admin-content">
            <div class="admin-topbar">
                <div>
                    <strong>@yield('page_title', 'Trang quản trị')</strong>
                </div>

                <div class="admin-user-box">
                    <span class="admin-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                        Trang chủ
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Đăng xuất</button>
                    </form>
                </div>
            </div>

            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>