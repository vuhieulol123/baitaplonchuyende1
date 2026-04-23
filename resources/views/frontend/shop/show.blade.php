@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row mb-5">
    <div class="col-lg-6 mb-4">
        <img src="{{ $product->thumbnail ?: 'https://via.placeholder.com/600x600?text=No+Image' }}"
             class="img-fluid rounded-4 shadow-sm w-100"
             alt="{{ $product->name }}"
             onerror="this.src='https://via.placeholder.com/600x600?text=Image+Error'">
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
@endsection