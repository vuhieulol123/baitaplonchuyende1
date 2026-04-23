@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page_title', 'Sửa sản phẩm')

@section('content')
    <h1 class="fw-bold mb-4">Sửa sản phẩm</h1>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                    @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá gốc</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Khuyến mãi hiện tại</label>
                    <input type="text" class="form-control" value="{{ $product->promotion_percent > 0 ? rtrim(rtrim(number_format($product->promotion_percent, 2, '.', ''), '0'), '.') . '%' : 'Không có khuyến mãi' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá sau khuyến mãi</label>
                    <input type="text" class="form-control" value="{{ number_format($product->final_price, 0, ',', '.') }} đ" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link ảnh</label>
                    <input type="text" name="thumbnail" class="form-control" placeholder="https://example.com/image.jpg" value="{{ old('thumbnail', $product->thumbnail) }}">
                    @error('thumbnail') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tồn kho</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                    @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="male" @selected(old('gender', $product->gender) === 'male')>Nam</option>
                        <option value="female" @selected(old('gender', $product->gender) === 'female')>Nữ</option>
                        <option value="unisex" @selected(old('gender', $product->gender) === 'unisex')>Unisex</option>
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Chất liệu</label>
                    <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
                    @error('material') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" @selected(old('status', $product->status) == 1)>Hiển thị</option>
                        <option value="0" @selected(old('status', $product->status) == 0)>Ẩn</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nổi bật</label>
                    <select name="is_featured" class="form-select">
                        <option value="1" @selected(old('is_featured', $product->is_featured) == 1)>Có</option>
                        <option value="0" @selected(old('is_featured', $product->is_featured) == 0)>Không</option>
                    </select>
                    @error('is_featured') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="alert alert-info mb-0">
                        Muốn đổi giá khuyến mãi, hãy vào mục <strong>Chương trình khuyến mãi</strong>. Giá ở đây được tính tự động.
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea name="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả chi tiết</label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Xem trước ảnh</label>
                    <div>
                        <img id="preview-image" src="{{ old('thumbnail', $product->thumbnail ?: 'https://via.placeholder.com/300x300?text=Preview') }}" class="img-fluid rounded-3 border" style="max-width: 220px;">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script>
        const thumbnailInput = document.querySelector('input[name="thumbnail"]');
        const previewImage = document.getElementById('preview-image');

        thumbnailInput.addEventListener('input', function () {
            previewImage.src = this.value || 'https://via.placeholder.com/300x300?text=Preview';
        });

        previewImage.addEventListener('error', function () {
            this.src = 'https://via.placeholder.com/300x300?text=Image+Error';
        });
    </script>
@endsection