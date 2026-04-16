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

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(request('brand') == $brand->slug)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="male" @selected(request('gender') == 'male')>Nam</option>
                        <option value="female" @selected(request('gender') == 'female')>Nữ</option>
                        <option value="unisex" @selected(request('gender') == 'unisex')>Unisex</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Giá từ</label>
                        <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Giá đến</label>
                        <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="">Mới nhất</option>
                        <option value="price_asc" @selected(request('sort') == 'price_asc')>Giá tăng dần</option>
                        <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá giảm dần</option>
                    </select>
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
                        <img src="{{ $product->thumbnail }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5>{{ $product->name }}</h5>
                            <p class="small text-muted">{{ $product->brand->name ?? 'Không có thương hiệu' }}</p>

                            @if($product->sale_price)
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