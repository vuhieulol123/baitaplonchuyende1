@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Quản lý đơn hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Quản lý đơn hàng</h1>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row mb-4">
            <div class="col-md-5 mb-2">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã đơn, tên khách, SĐT..." value="{{ request('keyword') }}">
            </div>

            <div class="col-md-3 mb-2">
                <select name="order_status" class="form-select">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="dang_xu_ly" @selected(request('order_status') == 'dang_xu_ly')>Đang xử lý</option>
                    <option value="dang_van_chuyen" @selected(request('order_status') == 'dang_van_chuyen')>Đang vận chuyển</option>
                    <option value="da_nhan_thanh_cong" @selected(request('order_status') == 'da_nhan_thanh_cong')>Đã nhận thành công</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <button class="btn btn-dark w-100">Lọc</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Thời gian đặt</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th width="140">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->order_code }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $statusText = match($order->order_status) {
                                        'dang_xu_ly' => 'Đang xử lý',
                                        'dang_van_chuyen' => 'Đang vận chuyển',
                                        'da_nhan_thanh_cong' => 'Đã nhận thành công',
                                        default => $order->order_status,
                                    };

                                    $statusClass = match($order->order_status) {
                                        'dang_xu_ly' => 'warning',
                                        'dang_van_chuyen' => 'info',
                                        'da_nhan_thanh_cong' => 'success',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-dark btn-sm">
                                    Xem đơn
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
@endsection