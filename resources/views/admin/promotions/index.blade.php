@extends('layouts.admin')

@section('title', 'Chương trình khuyến mãi')
@section('page_title', 'Chương trình khuyến mãi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Chương trình khuyến mãi</h1>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">+ Tạo khuyến mãi</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Tên chương trình</th>
                        <th>Dịp</th>
                        <th>Áp dụng</th>
                        <th>Giảm</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                        <th width="180">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promotion)
                        <tr>
                            <td class="fw-bold">{{ $promotion->name }}</td>
                            <td>{{ $promotion->occasion }}</td>
                            <td>
                                @if($promotion->apply_type === 'all')
                                    Tất cả sản phẩm
                                @elseif($promotion->apply_type === 'category')
                                    Nhóm: {{ $promotion->category->name ?? '' }}
                                @else
                                    {{ $promotion->products->count() }} sản phẩm
                                @endif
                            </td>
                            <td class="text-danger fw-bold">{{ rtrim(rtrim(number_format($promotion->discount_percent, 2, '.', ''), '0'), '.') }}%</td>
                            <td>{{ $promotion->start_date->format('d/m/Y') }}</td>
                            <td>{{ $promotion->end_date->format('d/m/Y') }}</td>
                            <td>
                                @if($promotion->status)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Tắt</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-primary btn-sm">Sửa</a>

                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa chương trình này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Chưa có chương trình khuyến mãi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $promotions->links() }}
        </div>
    </div>
@endsection