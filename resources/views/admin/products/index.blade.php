@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page_title', 'Quản lý sản phẩm')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Quản lý sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Thêm sản phẩm</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row mb-4">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">Tìm</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Giá gốc</th>
                        <th>Khuyến mãi</th>
                        <th>Giá sau KM</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th>Nổi bật</th>
                        <th width="180">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ $product->thumbnail }}" width="70" class="rounded-3"
                                         onerror="this.src='https://via.placeholder.com/70x70?text=No+Image'">
                                @else
                                    <img src="https://via.placeholder.com/70x70?text=No+Image" width="70" class="rounded-3">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '' }}</td>
                            <td>{{ $product->brand->name ?? '' }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>
                                @if($product->promotion_percent > 0)
                                    <span class="badge bg-danger">
                                        -{{ rtrim(rtrim(number_format($product->promotion_percent, 2, '.', ''), '0'), '.') }}%
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Không có</span>
                                @endif
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($product->final_price, 0, ',', '.') }} đ</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark">Có</span>
                                @else
                                    <span class="badge bg-light text-dark">Không</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm">Sửa</a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Chưa có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
@endsection