@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<h2 class="fw-bold mb-4">Giỏ hàng của bạn</h2>

@if(empty($cart))
    <div class="alert alert-warning">
        Giỏ hàng đang trống.
    </div>
    <a href="{{ route('shop.index') }}" class="btn btn-dark">Tiếp tục mua sắm</a>
@else
    @php
        $total = 0;
    @endphp

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tạm tính</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>
                                <img src="{{ $item['thumbnail'] }}" width="80" class="rounded-3">
                            </td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                            <td>
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="number" min="1" name="quantity" value="{{ $item['quantity'] }}" class="form-control" style="width: 90px;">
                                    <button class="btn btn-outline-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <h4>Tổng cộng: <span class="text-danger">{{ number_format($total, 0, ',', '.') }} đ</span></h4>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">Xóa toàn bộ</button>
            </form>

            <div class="d-flex gap-2">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">Tiếp tục mua</a>
                <a href="{{ route('checkout.index') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    </div>
@endif
@endsection