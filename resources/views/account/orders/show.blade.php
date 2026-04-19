@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Chi tiết đơn hàng</h1>
        <a href="{{ route('account.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Thông tin đơn hàng</h4>

                <div class="mb-3">
                    <div class="text-muted small">Mã đơn</div>
                    <div class="fw-bold">{{ $order->order_code }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Ngày đặt</div>
                    <div>{{ $order->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Khách hàng</div>
                    <div>{{ $order->customer_name }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Email</div>
                    <div>{{ $order->customer_email }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Số điện thoại</div>
                    <div>{{ $order->customer_phone }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Địa chỉ nhận hàng</div>
                    <div>{{ $order->shipping_address }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Phương thức thanh toán</div>
                    <div>
                        @if($order->payment_method === 'bank_transfer')
                            Chuyển khoản QR
                        @else
                            COD
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Trạng thái thanh toán</div>
                    <div>{{ $order->payment_status }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Trạng thái đơn hàng</div>
                    <div>{{ $order->order_status }}</div>
                </div>

                @if($order->note)
                    <div class="mb-3">
                        <div class="text-muted small">Ghi chú</div>
                        <div>{{ $order->note }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Sản phẩm trong đơn</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>SL</th>
                                <th>Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ number_format($item->product_price, 0, ',', '.') }} đ</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-bold">{{ number_format($item->subtotal, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-top pt-3 mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span>
                        <strong>{{ number_format($order->subtotal, 0, ',', '.') }} đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá</span>
                        <strong>{{ number_format($order->discount_amount, 0, ',', '.') }} đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí ship</span>
                        <strong>{{ number_format($order->shipping_fee, 0, ',', '.') }} đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <span class="fw-bold fs-5">Tổng cộng</span>
                        <strong class="text-danger fs-4">{{ number_format($order->total_amount, 0, ',', '.') }} đ</strong>
                    </div>
                </div>

                @if($order->payment_method === 'bank_transfer' && $order->payment_status !== 'paid')
                    <div class="mt-4">
                        <a href="{{ route('checkout.qr', $order) }}" class="btn btn-success">
                            Xem lại mã QR thanh toán
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection