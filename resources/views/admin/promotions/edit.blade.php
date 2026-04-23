@extends('layouts.admin')

@section('title', 'Sửa khuyến mãi')
@section('page_title', 'Sửa khuyến mãi')

@section('content')
    <h1 class="fw-bold mb-4">Sửa chương trình khuyến mãi</h1>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tên chương trình</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Dịp khuyến mãi</label>
                    <input type="text" name="occasion" class="form-control" value="{{ old('occasion', $promotion->occasion) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kiểu áp dụng</label>
                    <select name="apply_type" id="apply_type" class="form-select">
                        <option value="all" @selected($promotion->apply_type === 'all')>Tất cả sản phẩm</option>
                        <option value="category" @selected($promotion->apply_type === 'category')>Theo nhóm sản phẩm</option>
                        <option value="product" @selected($promotion->apply_type === 'product')>Theo sản phẩm cụ thể</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3" id="category_box" style="display:none;">
                    <label class="form-label">Chọn nhóm sản phẩm</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Chọn nhóm --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($promotion->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3" id="products_box" style="display:none;">
                    <label class="form-label">Chọn sản phẩm</label>
                    <select name="product_ids[]" class="form-select" multiple size="10">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(in_array($product->id, $selectedProducts))>
                                {{ $product->name }} - {{ number_format($product->price, 0, ',', '.') }} đ
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Giảm giá (%)</label>
                    <input type="number" name="discount_percent" class="form-control" min="1" max="100" step="0.01" value="{{ old('discount_percent', $promotion->discount_percent) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" @selected($promotion->status == 1)>Hoạt động</option>
                        <option value="0" @selected($promotion->status == 0)>Tắt</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $promotion->description) }}</textarea>
                </div>
            </div>

            <button class="btn btn-primary">Cập nhật khuyến mãi</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script>
        const applyType = document.getElementById('apply_type');
        const categoryBox = document.getElementById('category_box');
        const productsBox = document.getElementById('products_box');

        function toggleApplyFields() {
            const value = applyType.value;

            categoryBox.style.display = value === 'category' ? 'block' : 'none';
            productsBox.style.display = value === 'product' ? 'block' : 'none';
        }

        applyType.addEventListener('change', toggleApplyFields);
        toggleApplyFields();
    </script>
@endsection