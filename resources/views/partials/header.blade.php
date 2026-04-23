<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-1 me-4" href="{{ route('home') }}">
            GYM STORE PRO
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav me-auto align-items-lg-center gap-lg-2 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 fw-semibold" href="{{ route('home') }}">Trang chủ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-3 fw-semibold" href="{{ route('shop.index') }}">Cửa hàng</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-3 fw-semibold" href="{{ route('account.orders.index') }}">
                            Đơn hàng của tôi
                        </a>
                    </li>
                @endauth
            </ul>

            <form class="d-flex align-items-center gap-2 me-3" action="{{ route('shop.index') }}" method="GET">
                <input
                    class="form-control rounded-3"
                    type="search"
                    name="keyword"
                    placeholder="Tìm sản phẩm..."
                    value="{{ request('keyword') }}"
                    style="min-width: 220px; max-width: 260px;"
                >
                <button class="btn btn-dark rounded-3 px-4" type="submit">Tìm</button>
            </form>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2">
                    Giỏ hàng
                </a>

                @auth
                    <span class="fw-semibold px-2" style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ auth()->user()->name }}
                    </span>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-3 px-3 py-2">
                            Vào Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger rounded-3 px-3 py-2">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3 px-3 py-2">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-3 px-3 py-2">
                        Đăng ký
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>