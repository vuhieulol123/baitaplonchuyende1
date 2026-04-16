<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::with(['category', 'brand'])
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('status', true)
            ->latest()
            ->get();

        return view('frontend.home', compact(
            'banners',
            'featuredProducts',
            'newProducts',
            'categories'
        ));
    }
}