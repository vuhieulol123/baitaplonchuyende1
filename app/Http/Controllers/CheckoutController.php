<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        return view('frontend.checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:2000',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'customer_email.required' => 'Vui lòng nhập email.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $shippingFee = 30000;
            $discountAmount = 0;
            $totalAmount = $subtotal + $shippingFee;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'GYM-' . strtoupper(Str::random(8)),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'note' => $request->note,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_method' => 'cod',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'coupon_code' => null,
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['id']);

                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại.');
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Sản phẩm "' . $product->name . '" không đủ tồn kho.');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_description' => null,
                    'product_name' => $product->name,
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Đặt hàng thành công. Mã đơn: ' . $order->order_code);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi đặt hàng: ' . $e->getMessage());
        }
    }
}