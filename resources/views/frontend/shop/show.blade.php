@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row mb-5">
    <div class="col-lg-6 mb-4">
        <img src="{{ $product->thumbnail }}" class="img-fluid rounded-4 shadow-sm w-100" alt="{{ $product->name }}">

        @if($product->images->count())
            <div class="row mt-3">
                @foreach($product->images as $image)
                    <div class="col-3 mb-3">
                        <img src="{{ $image->image_path }}" class="img-fluid rounded-3 shadow-sm" alt="">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="col-lg-6">
        <h1 class="fw-bold">{{ $product->name }}</h1>
        <p class="text-muted">SKU: {{ $product->sku }}</p>
        <p>Danh mục: <strong>{{ $product->category->name ?? '' }}</strong></p>
        <p>Thương hiệu: <strong>{{ $product->brand->name ?? '' }}</strong></p>
        <p>Chất liệu: <strong>{{ $product->material }}</strong></p>
        <p>Tồn kho: <strong>{{ $product->stock }}</strong></p>

        @if($product->sale_price)
            <div class="price-old mb-1">{{ number_format($product->price, 0, ',', '.') }} đ</div>
        @endif
        <div class="price-new mb-3">{{ number_format($product->final_price, 0, ',', '.') }} đ</div>

        <p>{{ $product->short_description }}</p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
            @csrf
            <button class="btn btn-danger btn-lg">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
    <h3 class="fw-bold mb-3">Mô tả chi tiết</h3>
    <p>{!! nl2br(e($product->description)) !!}</p>
</div>

<div class="mb-5">
    <h3 class="fw-bold mb-4">Sản phẩm liên quan</h3>
    <div class="row">
        @foreach($relatedProducts as $item)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h5>{{ $item->name }}</h5>
                        <div class="price-new">{{ number_format($item->final_price, 0, ',', '.') }} đ</div>
                        <a href="{{ route('shop.show', $item->slug) }}" class="btn btn-dark mt-3 w-100">Xem ngay</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <h3 class="fw-bold mb-4">Đánh giá sản phẩm</h3>

    @forelse($product->reviews as $review)
        <div class="border-bottom pb-3 mb-3">
            <strong>{{ $review->user->name ?? 'Người dùng' }}</strong>
            <div>⭐ {{ $review->rating }}/5</div>
            <p class="mb-0">{{ $review->comment }}</p>
        </div>
    @empty
        <p class="text-muted mb-0">Chưa có đánh giá nào.</p>
    @endforelse
</div>
@endsection