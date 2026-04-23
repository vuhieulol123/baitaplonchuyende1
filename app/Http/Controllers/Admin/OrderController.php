<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_code', 'like', '%' . $request->keyword . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:dang_xu_ly,dang_van_chuyen,da_nhan_thanh_cong',
        ]);

        $order->order_status = $request->order_status;

        if ($request->order_status === 'da_nhan_thanh_cong') {
            $order->payment_status = 'paid';
        }

        $order->save();

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}