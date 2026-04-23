<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with(['category', 'products'])->latest()->paginate(10);

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $products = Product::where('status', true)->latest()->get();

        return view('admin.promotions.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'apply_type' => 'required|in:all,category,product',
            'category_id' => 'nullable|exists:categories,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $promotion = Promotion::create([
            'name' => $request->name,
            'occasion' => $request->occasion,
            'description' => $request->description,
            'apply_type' => $request->apply_type,
            'category_id' => $request->apply_type === 'category' ? $request->category_id : null,
            'discount_percent' => $request->discount_percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        if ($request->apply_type === 'product' && $request->filled('product_ids')) {
            $promotion->products()->sync($request->product_ids);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Tạo chương trình khuyến mãi thành công.');
    }

    public function edit(Promotion $promotion)
    {
        $categories = Category::where('status', true)->get();
        $products = Product::where('status', true)->latest()->get();
        $selectedProducts = $promotion->products()->pluck('products.id')->toArray();

        return view('admin.promotions.edit', compact('promotion', 'categories', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'apply_type' => 'required|in:all,category,product',
            'category_id' => 'nullable|exists:categories,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
        ]);

        $promotion->update([
            'name' => $request->name,
            'occasion' => $request->occasion,
            'description' => $request->description,
            'apply_type' => $request->apply_type,
            'category_id' => $request->apply_type === 'category' ? $request->category_id : null,
            'discount_percent' => $request->discount_percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        if ($request->apply_type === 'product') {
            $promotion->products()->sync($request->product_ids ?? []);
        } else {
            $promotion->products()->sync([]);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật chương trình khuyến mãi thành công.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->products()->detach();
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Xóa chương trình khuyến mãi thành công.');
    }
}