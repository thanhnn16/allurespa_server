<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Allure Spa Server

Hướng dẫn chạy server và test:
1. Cài đặt composer
2. Cài đặt nodejs
3. Cài đặt xampp
4. Cài đặt git
5. Clone project về máy
6. Mở terminal trong thư mục project
7. Chạy lệnh `composer install`
8. Chạy lệnh `npm install`
9. Mở file `.env.example` và đổi tên thành `.env`
10. Generate key bằng lệnh `php artisan key:generate`
11. Chạy lệnh tạo database trong file `allure_spa.sql`
12. Migration database bằng lệnh `php artisan migrate`
13. Vào file `.env` và sửa lại thông tin database:
    _DB_DATABASE=allure_dev_
    _DB_USERNAME=root_
    _DB_PASSWORD=_**Password của mysql server**
14. Chạy lệnh `php artisan serve`
15. Mở trình duyệt và truy cập vào đường dẫn `http://localhost:8000/`
