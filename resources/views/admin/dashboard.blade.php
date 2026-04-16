@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="fw-bold mb-4">Trang quản trị</h1>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5>Sản phẩm</h5>
                <p class="display-6 fw-bold">--</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5>Đơn hàng</h5>
                <p class="display-6 fw-bold">--</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5>Khách hàng</h5>
                <p class="display-6 fw-bold">--</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5>Doanh thu</h5>
                <p class="display-6 fw-bold">--</p>
            </div>
        </div>
    </div>
@endsection