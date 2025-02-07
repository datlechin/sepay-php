# SePay PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/datlechin/sepay-php.svg?style=flat-square)](https://packagist.org/packages/datlechin/sepay-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/datlechin/sepay-php/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/datlechin/sepay-php/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/datlechin/sepay-php.svg?style=flat-square)](https://packagist.org/packages/datlechin/sepay-php)

SePay PHP là một thư viện PHP giúp tích hợp dịch vụ thanh toán SePay vào ứng dụng của bạn một cách dễ dàng. Thư viện này cung cấp các phương thức để quản lý tài khoản ngân hàng, theo dõi giao dịch và xử lý webhook.

## Cài đặt

Bạn có thể cài đặt gói này thông qua Composer:

```bash
composer require datlechin/sepay-php
```

## Cách sử dụng

### Khởi tạo Client

Vào trang [SePay](https://my.sepay.vn/companyapi) để lấy API Key.

```php
use Datlechin\SePay\SePay;

$client = SePay::client('your_api_key_here');
```

### Quản lý tài khoản ngân hàng

```php
// Lấy danh sách tài khoản ngân hàng
$bankAccounts = $client->bankAccounts()->list();

// Lấy thông tin một tài khoản cụ thể
$account = $client->bankAccounts()->get($accountId);

// Đếm số lượng tài khoản
$count = $client->bankAccounts()->count();
```

### Quản lý giao dịch

```php
// Lấy danh sách giao dịch
$transactions = $client->transactions()->list();

// Lấy thông tin một giao dịch cụ thể
$transaction = $client->transactions()->get($transactionId);

// Đếm số lượng giao dịch
$count = $client->transactions()->count();
```

### Xử lý Webhook

```php
use Datlechin\SePay\SePay;
use Datlechin\SePay\Webhook\Payload;
use Datlechin\SePay\Webhook\Webhook;

SePay::webhook()
    ->setAuthorization(Webhook::AUTH_API_KEY, 'your_api_key_here')
    ->handle(function (Payload $payload) {
    // Xử lý webhook như lưu thông tin giao dịch hay cập nhật trạng thái đơn hàng...

    return true; // Trả về true để xác nhận webhook hợp lệ hoặc false nếu không hợp lệ
});
```

## Kiểm thử

```bash
composer test
```

## Tác giả

- [Ngo Quoc Dat](https://github.com/datlechin)
- [Tất cả những người đóng góp](../../contributors)

## Giấy phép

Giấy phép MIT (MIT). Vui lòng xem [Tệp Giấy phép](LICENSE) để biết thêm thông tin.
