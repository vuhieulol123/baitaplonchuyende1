<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'sale_price',
        'thumbnail',
        'gender',
        'material',
        'stock',
        'status',
        'is_featured',
        'view_count',
    ];

    protected $appends = [
        'final_price',
        'promotion_percent',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'status' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    public function getPromotionPercentAttribute(): float
    {
        $today = Carbon::today();

        $productPromotion = $this->promotions()
            ->where('status', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderByDesc('discount_percent')
            ->first();

        $categoryPromotion = Promotion::where('status', true)
            ->where('apply_type', 'category')
            ->where('category_id', $this->category_id)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderByDesc('discount_percent')
            ->first();

        $allPromotion = Promotion::where('status', true)
            ->where('apply_type', 'all')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderByDesc('discount_percent')
            ->first();

        $percents = collect([
            $productPromotion?->discount_percent,
            $categoryPromotion?->discount_percent,
            $allPromotion?->discount_percent,
        ])->filter();

        return (float) ($percents->max() ?? 0);
    }

   public function getFinalPriceAttribute(): float
{
    $basePrice = (float) $this->price;
    $promotionPercent = (float) $this->promotion_percent;

    if ($promotionPercent > 0) {
        return (float) ($basePrice - ($basePrice * $promotionPercent / 100));
    }

    return $basePrice;
}
}