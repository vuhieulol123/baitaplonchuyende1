@extends('layouts.app')

@section('title', 'Thanh toán QR')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <h2 class="fw-bold mb-3">Thanh toán đơn hàng bằng QR</h2>
            <p class="text-muted mb-4">
                Quét mã bên dưới để thanh toán cho đơn hàng <strong>{{ $order->order_code }}</strong>
            </p>

            <div class="mb-4">
                <img src="{{ $vietQrUrl }}" alt="QR thanh toán" class="img-fluid rounded-4 border" style="max-width: 420px;">
            </div>

            <div class="row text-start">
                <div class="col-md-6 mb-3">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="text-muted small">Mã đơn hàng</div>
                        <div class="fw-bold">{{ $order->order_code }}</div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="text-muted small">Số tiền cần thanh toán</div>
                        <div class="fw-bold text-danger fs-4">{{ number_format($order->total_amount, 0, ',', '.') }} đ</div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="text-muted small">Tên người nhận</div>
                        <div class="fw-bold">{{ config('services.vietqr.account_name') }}</div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="border rounded-4 p-3 h-100">
                        <div class="text-muted small">Số tài khoản</div>
                        <div class="fw-bold">{{ config('services.vietqr.account_no') }}</div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="border rounded-4 p-3">
                        <div class="text-muted small">Nội dung chuyển khoản</div>
                        <div class="fw-bold">{{ $transferContent }}</div>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning text-start mt-3">
                <strong>Lưu ý:</strong> bạn nên chuyển đúng số tiền và đúng nội dung để dễ đối soát đơn hàng.
            </div>

            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="{{ route('home') }}" class="btn btn-outline-dark">Về trang chủ</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark {{ auth()->user()->role !== 'admin' ? 'd-none' : '' }}">Vào admin</a>
            </div>
        </div>
    </div>
</div>
@endsection