@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard quản trị')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Trang quản trị</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-dark">Quản lý sản phẩm</a>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h5>Tổng sản phẩm</h5>
                <p class="display-6 fw-bold">{{ $totalProducts }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h5>Tổng đơn hàng</h5>
                <p class="display-6 fw-bold">{{ $totalOrders }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h5>Khách hàng</h5>
                <p class="display-6 fw-bold">{{ $totalCustomers }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h5>Doanh thu</h5>
                <p class="display-6 fw-bold text-danger">{{ number_format($totalRevenue, 0, ',', '.') }} đ</p>
            </div>
        </div>
    </div>

    <div class="card stat-card p-4 mt-3">
        <h4 class="fw-bold mb-3">Đơn hàng gần đây</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->order_status }}</td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection