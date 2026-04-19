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

        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = 30000;
        $discountAmount = 0;
        $totalAmount = $subtotal + $shippingFee - $discountAmount;

        $previewOrderCode = 'GYM-' . strtoupper(Str::random(8));
        $transferContent = 'TT ' . $previewOrderCode;

        $vietQrUrl = $this->buildVietQrUrl(
            $totalAmount,
            $transferContent
        );

        return view('frontend.checkout.index', compact(
            'cart',
            'subtotal',
            'shippingFee',
            'discountAmount',
            'totalAmount',
            'previewOrderCode',
            'transferContent',
            'vietQrUrl'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:2000',
            'payment_method' => 'required|in:cod,bank_transfer',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'customer_email.required' => 'Vui lòng nhập email.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
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
            $totalAmount = $subtotal + $shippingFee - $discountAmount;

            $orderCode = 'GYM-' . strtoupper(Str::random(8));

            $paymentStatus = $request->payment_method === 'bank_transfer' ? 'pending_transfer' : 'unpaid';

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'note' => $request->note,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
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

            if ($request->payment_method === 'bank_transfer') {
                return redirect()->route('checkout.qr', $order->id)
                    ->with('success', 'Đơn hàng đã được tạo. Vui lòng quét QR để thanh toán.');
            }

            return redirect()->route('home')->with('success', 'Đặt hàng COD thành công. Mã đơn: ' . $order->order_code);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi đặt hàng: ' . $e->getMessage());
        }
    }

    public function qr(Order $order)
    {
        if (!auth()->check() || (auth()->id() !== $order->user_id && auth()->user()->role !== 'admin')) {
            abort(403);
        }

        $transferContent = 'TT ' . $order->order_code;

        $vietQrUrl = $this->buildVietQrUrl(
            $order->total_amount,
            $transferContent
        );

        return view('frontend.checkout.qr', compact('order', 'transferContent', 'vietQrUrl'));
    }

    private function buildVietQrUrl($amount, string $transferContent): string
    {
        $bankId = config('services.vietqr.bank_id');
        $accountNo = config('services.vietqr.account_no');
        $accountName = config('services.vietqr.account_name');

        $baseUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png";

        return $baseUrl . '?' . http_build_query([
            'amount' => (int) $amount,
            'addInfo' => $transferContent,
            'accountName' => $accountName,
        ]);
    }
}