@extends('layouts.app')

@section('title', 'Sửa sản phẩm')

@section('content')
    <h1 class="fw-bold mb-4">Sửa sản phẩm</h1>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @selected($product->brand_id == $brand->id)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá gốc</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá khuyến mãi</label>
                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tồn kho</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="male" @selected($product->gender === 'male')>Nam</option>
                        <option value="female" @selected($product->gender === 'female')>Nữ</option>
                        <option value="unisex" @selected($product->gender === 'unisex')>Unisex</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Chất liệu</label>
                    <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ảnh đại diện mới</label>
                    <input type="file" name="thumbnail" class="form-control">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail }}" width="100" class="mt-2 rounded-3">
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" @selected($product->status == 1)>Hiển thị</option>
                        <option value="0" @selected($product->status == 0)>Ẩn</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nổi bật</label>
                    <select name="is_featured" class="form-select">
                        <option value="1" @selected($product->is_featured == 1)>Có</option>
                        <option value="0" @selected($product->is_featured == 0)>Không</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea name="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả chi tiết</label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <button class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection