<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gymstore.com'],
            [
                'name' => 'Admin Gym Store',
                'phone' => '0900000001',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gymstore.com'],
            [
                'name' => 'User Demo',
                'phone' => '0900000002',
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'is_active' => true,
            ]
        );

        $categories = [
            ['name' => 'Áo tập gym', 'slug' => 'ao-tap-gym'],
            ['name' => 'Quần tập gym', 'slug' => 'quan-tap-gym'],
            ['name' => 'Phụ kiện gym', 'slug' => 'phu-kien-gym'],
            ['name' => 'Găng tay', 'slug' => 'gang-tay'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => 'Danh mục ' . $category['name'],
                    'status' => true,
                ]
            );
        }

        $brands = [
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Under Armour', 'slug' => 'under-armour'],
            ['name' => 'Gymshark', 'slug' => 'gymshark'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                [
                    'name' => $brand['name'],
                    'description' => 'Thương hiệu ' . $brand['name'],
                    'status' => true,
                ]
            );
        }

        Banner::updateOrCreate(
            ['title' => 'Bộ sưu tập đồ tập gym mới'],
            [
                'subtitle' => 'Nâng tầm hiệu suất tập luyện với thời trang thể thao cao cấp.',
                'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438',
                'button_text' => 'Mua ngay',
                'button_link' => '/shop',
                'sort_order' => 1,
                'status' => true,
            ]
        );

        $categoryIds = Category::pluck('id')->toArray();
        $brandIds = Brand::pluck('id')->toArray();

        $products = [
            'Áo thun gym nam dry-fit',
            'Áo ba lỗ tập gym cao cấp',
            'Quần jogger thể thao co giãn',
            'Quần short tập gym nam',
            'Găng tay tập tạ chống trượt',
            'Đai lưng tập gym chuyên dụng',
            'Bình nước thể thao 1L',
            'Túi đựng đồ tập gym',
        ];

        foreach ($products as $index => $name) {
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'brand_id' => $brandIds[array_rand($brandIds)],
                    'name' => $name,
                    'sku' => 'SKU' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'short_description' => 'Sản phẩm chất lượng cao dành cho gymer.',
                    'description' => 'Đây là mô tả chi tiết cho sản phẩm ' . $name . '. Chất liệu bền đẹp, thoáng khí, phù hợp tập luyện cường độ cao.',
                    'price' => rand(150000, 800000),
                    'sale_price' => rand(100000, 600000),
                    'thumbnail' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a',
                    'gender' => ['male', 'female', 'unisex'][array_rand(['male', 'female', 'unisex'])],
                    'material' => 'Polyester co giãn 4 chiều',
                    'stock' => rand(10, 100),
                    'status' => true,
                    'is_featured' => rand(0, 1),
                    'view_count' => rand(0, 500),
                ]
            );
        }
    }
}