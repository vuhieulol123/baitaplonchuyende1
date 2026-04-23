@extends('layouts.app')

@section('title', 'Cửa hàng')

@section('content')
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <h5 class="mb-3">Bộ lọc sản phẩm</h5>

            <form method="GET" action="{{ route('shop.index') }}">
                <div class="mb-3">
                    <label class="form-label">Từ khóa</label>
                    <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}">
                </div>

                <button class="btn btn-dark w-100">Lọc sản phẩm</button>
            </form>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Tất cả sản phẩm</h2>
            <span class="text-muted">{{ $products->total() }} sản phẩm</span>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img src="{{ $product->thumbnail ?: 'https://via.placeholder.com/400x400?text=No+Image' }}"
                             class="card-img-top"
                             alt="{{ $product->name }}"
                             onerror="this.src='https://via.placeholder.com/400x400?text=Image+Error'">

                        <div class="card-body">
                            <h5>{{ $product->name }}</h5>
                            <p class="small text-muted">{{ $product->brand->name ?? 'Không có thương hiệu' }}</p>

                            @if($product->promotion_percent > 0)
                                <div class="price-old">{{ number_format($product->price, 0, ',', '.') }} đ</div>
                            @endif

                            <div class="price-new">{{ number_format($product->final_price, 0, ',', '.') }} đ</div>
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('shop.show', $product->slug) }}" class="btn btn-outline-dark w-100">Chi tiết</a>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button class="btn btn-danger w-100">Thêm giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Không tìm thấy sản phẩm phù hợp.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection