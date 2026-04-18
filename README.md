# Gym Store Pro

Ứng dụng web bán đồ tập gym xây dựng bằng Laravel 12, Blade và Bootstrap.

## Yêu cầu môi trường

- PHP 8.2 trở lên
- Composer
- Node.js 20 trở lên và npm
- SQLite hoặc MySQL

## Chạy dự án nhanh với SQLite

1. Clone repository.
2. Cài package PHP, tạo file môi trường, tạo app key, migrate và build frontend:

```bash
composer run setup
```

3. Seed dữ liệu mẫu:

```bash
php artisan db:seed
```

4. Chạy ứng dụng:

```bash
composer run dev
```

Mặc định dự án dùng SQLite qua `database/database.sqlite`.

## Chạy thủ công

```bash
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

## Tài khoản demo

- Admin: `admin@gymstore.com` / `12345678`
- User: `user@gymstore.com` / `12345678`

## Tính năng chính

- Trang chủ hiển thị banner, danh mục và sản phẩm nổi bật
- Danh sách sản phẩm có lọc theo từ khóa, danh mục, thương hiệu, giới tính và giá
- Chi tiết sản phẩm, giỏ hàng và đặt hàng
- Xác thực người dùng với Laravel Breeze
- Phân quyền `admin` và `customer`

## Ghi chú

- Không commit `.env`, `vendor`, `node_modules`, `storage/logs`, `public/build` vì đây là file môi trường hoặc file sinh ra khi cài đặt.
- Repo đã giữ lại toàn bộ source code, `composer.lock`, `package-lock.json`, migration và seeder để người khác clone về có thể cài và chạy lại đúng cách.
