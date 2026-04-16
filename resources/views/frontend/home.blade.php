@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    @if($banners->count())
        @php $banner = $banners->first(); @endphp
        <div class="banner-card mb-5" style="background-image: url('{{ $banner->image }}')">
            <div class="banner-overlay">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold">{{ $banner->title }}</h1>
                    <p class="lead">{{ $banner->subtitle }}</p>
                    <a href="{{ $banner->button_link ?? route('shop.index') }}" class="btn btn-danger btn-lg">
                        {{ $banner->button_text ?? 'Mua ngay' }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="hero mb-5">
            <h1 class="display-5 fw-bold">Đồ tập gym cao cấp</h1>
            <p class="lead">Thiết kế mạnh mẽ, chất liệu bền bỉ, tối ưu cho hiệu suất tập luyện.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-danger btn-lg">Khám phá ngay</a>
        </div>
    @endif

    <section class="mb-5">
        <h2 class="section-title">Danh mục nổi bật</h2>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-3 mb-4">
                    <div class="card product-card text-center p-4">
                        <h5>{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->description }}</p>
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="btn btn-dark">
                            Xem sản phẩm
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-5">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="{{ $product->thumbnail }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted small">{{ $product->category->name ?? '' }}</p>

                            @if($product->sale_price)
                                <div class="price-old">{{ number_format($product->price, 0, ',', '.') }} đ</div>
                            @endif
                            <div class="price-new">{{ number_format($product->final_price, 0, ',', '.') }} đ</div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('shop.show', $product->slug) }}" class="btn btn-outline-dark w-100">Chi tiết</a>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button class="btn btn-danger w-100">Mua</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="section-title">Sản phẩm mới</h2>
        <div class="row">
            @foreach($newProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="{{ $product->thumbnail }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <div class="price-new">{{ number_format($product->final_price, 0, ',', '.') }} đ</div>
                            <a href="{{ route('shop.show', $product->slug) }}" class="btn btn-dark mt-3 w-100">Xem ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection