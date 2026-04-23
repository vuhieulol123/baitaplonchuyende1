@extends('layouts.admin')

@section('title', 'Báo cáo thống kê')
@section('page_title', 'Báo cáo thống kê')

@section('content')
    <h1 class="fw-bold mb-4">Báo cáo thống kê</h1>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Tổng hàng tồn kho</h6>
                <p class="display-6 fw-bold">{{ number_format($totalStock, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Tổng sản phẩm</h6>
                <p class="display-6 fw-bold">{{ number_format($totalProducts, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Tổng đơn hàng</h6>
                <p class="display-6 fw-bold">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Tổng khách hàng</h6>
                <p class="display-6 fw-bold">{{ number_format($totalCustomers, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Doanh thu hôm nay</h6>
                <p class="display-6 fw-bold text-danger">{{ number_format($revenueToday, 0, ',', '.') }} đ</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Doanh thu tháng này</h6>
                <p class="display-6 fw-bold text-danger">{{ number_format($revenueThisMonth, 0, ',', '.') }} đ</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card p-4">
                <h6 class="text-muted">Doanh thu năm nay</h6>
                <p class="display-6 fw-bold text-danger">{{ number_format($revenueThisYear, 0, ',', '.') }} đ</p>
            </div>
        </div>
    </div>

    <div class="card stat-card p-4 mb-4">
        <h4 class="fw-bold mb-3">Doanh thu 7 ngày gần nhất</h4>
        <canvas id="dailyRevenueChart" height="100"></canvas>
    </div>

    <div class="card stat-card p-4 mb-4">
        <h4 class="fw-bold mb-3">Doanh thu theo tháng trong năm</h4>
        <canvas id="monthlyRevenueChart" height="100"></canvas>
    </div>

    <div class="card stat-card p-4 mb-4">
        <h4 class="fw-bold mb-3">Doanh thu theo năm</h4>
        <canvas id="yearlyRevenueChart" height="100"></canvas>
    </div>

    <div class="card stat-card p-4">
        <h4 class="fw-bold mb-3">Sản phẩm sắp hết hàng</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>SKU</th>
                        <th>Tồn kho</th>
                        <th>Giá bán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $product->stock }}</span>
                            </td>
                            <td class="text-danger fw-bold">
                                {{ number_format($product->final_price, 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Không có sản phẩm nào sắp hết hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dailyLabels = @json($dailyLabels);
        const dailyTotals = @json($dailyTotals);

        const monthlyLabels = @json($monthlyLabels);
        const monthlyTotals = @json($monthlyTotals);

        const yearlyLabels = @json($yearlyLabels);
        const yearlyTotals = @json($yearlyTotals);

        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: dailyTotals,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                }
            }
        });

        new Chart(document.getElementById('monthlyRevenueChart'), {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: monthlyTotals,
                    borderColor: 'rgb(220, 53, 69)',
                    backgroundColor: 'rgba(220, 53, 69, 0.15)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                }
            }
        });

        new Chart(document.getElementById('yearlyRevenueChart'), {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: yearlyTotals,
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                }
            }
        });
    </script>
@endsection