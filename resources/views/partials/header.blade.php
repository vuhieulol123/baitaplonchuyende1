<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">GYM STORE PRO</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.index') }}">Cửa hàng</a>
                </li>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Quản trị</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <form class="d-flex me-3" action="{{ route('shop.index') }}" method="GET">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm sản phẩm...">
                <button class="btn btn-dark" type="submit">Tìm</button>
            </form>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark">Giỏ hàng</a>

                @auth
                    <span class="fw-semibold">{{ auth()->user()->name }}</span>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Admin</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
