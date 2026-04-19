@extends('layouts.app')

@section('title', 'Thêm sản phẩm')

@section('content')
    <h1 class="fw-bold mb-4">Thêm sản phẩm</h1>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá gốc</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá khuyến mãi</label>
                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tồn kho</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="unisex">Unisex</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Chất liệu</label>
                    <input type="text" name="material" class="form-control" value="{{ old('material') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ảnh đại diện</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nổi bật</label>
                    <select name="is_featured" class="form-select">
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea name="short_description" rows="3" class="form-control">{{ old('short_description') }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả chi tiết</label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>

            <button class="btn btn-success">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection