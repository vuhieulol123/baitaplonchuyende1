<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])->latest();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|url|max:2048',
            'gender' => 'required|in:male,female,unisex',
            'material' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'is_featured' => 'required|boolean',
        ], [
            'thumbnail.url' => 'Link ảnh không hợp lệ.',
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'thumbnail' => $request->thumbnail,
            'gender' => $request->gender,
            'material' => $request->material,
            'stock' => $request->stock,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'view_count' => 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|url|max:2048',
            'gender' => 'required|in:male,female,unisex',
            'material' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'is_featured' => 'required|boolean',
        ], [
            'thumbnail.url' => 'Link ảnh không hợp lệ.',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'thumbnail' => $request->thumbnail,
            'gender' => $request->gender,
            'material' => $request->material,
            'stock' => $request->stock,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }
}