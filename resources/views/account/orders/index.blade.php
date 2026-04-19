@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Đơn hàng của tôi</h1>
        <a href="{{ route('shop.index') }}" class="btn btn-dark">Mua thêm</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái đơn</th>
                        <th>Tổng tiền</th>
                        <th width="150">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->order_code }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($order->payment_method === 'bank_transfer')
                                    <span class="badge bg-info">Chuyển khoản</span>
                                @else
                                    <span class="badge bg-secondary">COD</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($order->order_status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'primary',
                                        'shipping' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="text-danger fw-bold">
                                {{ number_format($order->total_amount, 0, ',', '.') }} đ
                            </td>
                            <td>
                                <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline-dark btn-sm">
                                    Xem đơn
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Bạn chưa có đơn hàng nào.
                            </td>
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