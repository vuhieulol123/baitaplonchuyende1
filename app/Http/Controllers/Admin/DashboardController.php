<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $totalRevenue = Order::whereIn('order_status', [
            'dang_xu_ly',
            'dang_van_chuyen',
            'da_nhan_thanh_cong'
        ])->sum('total_amount');

        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}