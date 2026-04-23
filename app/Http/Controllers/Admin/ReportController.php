<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $completedStatuses = ['dang_xu_ly', 'dang_van_chuyen', 'da_nhan_thanh_cong'];

        $totalStock = Product::sum('stock');
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $revenueToday = Order::whereIn('order_status', $completedStatuses)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $revenueThisMonth = Order::whereIn('order_status', $completedStatuses)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');

        $revenueThisYear = Order::whereIn('order_status', $completedStatuses)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');

        $dailyRevenue = Order::selectRaw('DATE(created_at) as label, SUM(total_amount) as total')
            ->whereIn('order_status', $completedStatuses)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6)->toDateString())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('label')
            ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month_number, SUM(total_amount) as total')
            ->whereIn('order_status', $completedStatuses)
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month_number')
            ->get();

        $yearlyRevenue = Order::selectRaw('YEAR(created_at) as year_number, SUM(total_amount) as total')
            ->whereIn('order_status', $completedStatuses)
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('year_number')
            ->get();

        $dailyLabels = [];
        $dailyTotals = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $found = $dailyRevenue->firstWhere('label', $date);

            $dailyLabels[] = Carbon::parse($date)->format('d/m');
            $dailyTotals[] = $found ? (float) $found->total : 0;
        }

        $monthlyLabels = [];
        $monthlyTotals = [];

        for ($month = 1; $month <= 12; $month++) {
            $found = $monthlyRevenue->firstWhere('month_number', $month);

            $monthlyLabels[] = 'Tháng ' . $month;
            $monthlyTotals[] = $found ? (float) $found->total : 0;
        }

        $yearlyLabels = $yearlyRevenue->pluck('year_number')->map(fn ($year) => 'Năm ' . $year)->values();
        $yearlyTotals = $yearlyRevenue->pluck('total')->map(fn ($total) => (float) $total)->values();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalStock',
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'revenueToday',
            'revenueThisMonth',
            'revenueThisYear',
            'dailyLabels',
            'dailyTotals',
            'monthlyLabels',
            'monthlyTotals',
            'yearlyLabels',
            'yearlyTotals',
            'lowStockProducts'
        ));
    }
}