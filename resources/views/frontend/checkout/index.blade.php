@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
@php
    $subtotal = 0;
    foreach($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $shipping = 30000;
    $total = $subtotal + $shipping;
@endphp

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h3 class="fw-bold mb-4">Thông tin nhận hàng</h3>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', auth()->user()->name ?? '') }}">
                    @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                    @error('customer_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}">
                    @error('customer_phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <textarea name="shipping_address" rows="4" class="form-control">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                </div>

                <button class="btn btn-success btn-lg">Xác nhận đặt hàng</button>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h3 class="fw-bold mb-4">Đơn hàng của bạn</h3>

            @foreach($cart as $item)
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <div>
                        <strong>{{ $item['name'] }}</strong>
                        <div class="text-muted">SL: {{ $item['quantity'] }}</div>
                    </div>
                    <div>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-3">
                <span>Tạm tính</span>
                <strong>{{ number_format($subtotal, 0, ',', '.') }} đ</strong>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <span>Phí ship</span>
                <strong>{{ number_format($shipping, 0, ',', '.') }} đ</strong>
            </div>
            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                <span class="fw-bold">Tổng cộng</span>
                <strong class="text-danger">{{ number_format($total, 0, ',', '.') }} đ</strong>
            </div>
        </div>
    </div>
</div>
@endsection