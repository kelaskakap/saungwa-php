Mantap 🚀
Berikut draft **README.md final** (sudah pakai `dev-master` dan siap kamu taruh di GitHub repo):

---

````markdown
# Saungwa PHP Client

[![PHP](https://img.shields.io/badge/PHP-^8.3-blue)](https://www.php.net/releases/8.3/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

Unofficial **PHP client library** untuk [Saungwa WhatsApp API](https://saungwa.com/api).  
Dibuat dengan **PHP 8.3**, berbasis **OOP** dan mengikuti prinsip **SOLID**.  
Bisa digunakan di berbagai project PHP:  
- Native PHP  
- Laravel 12 (support out of the box)  
- Framework lain (CodeIgniter, Symfony, Lumen, dsb)

---

## ✨ Fitur

- 🔑 Authentikasi dengan `appkey` & `authkey`  
- 💬 Kirim pesan teks, template, atau file via Saungwa API  
- 🧩 Desain SOLID (bisa ganti HTTP client adapter)  
- ⚡ Integrasi Laravel 12 (ServiceProvider + Facade)  
- 🛠 Framework-agnostic (bisa dipakai di project PHP apa saja)  

---

## 📦 Instalasi

Tambahkan repository GitHub ke `composer.json` project Anda:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/kelaskakap/saungwa-php.git"
    }
  ]
}
````

Lalu jalankan:

```bash
composer require kelaskakap/saungwa-php:dev-master
```

Library otomatis masuk ke folder `vendor/` dan bisa dipakai dengan:

```php
require 'vendor/autoload.php';
```

---

## ⚙️ Konfigurasi

### Native PHP

```php
use Saungwa\Config;
use Saungwa\Http\GuzzleHttpClient;
use Saungwa\SaungwaClient;

$config = new Config('your-appkey', 'your-authkey', 'https://app.saungwa.com/api', false);
$http = new GuzzleHttpClient($config->getBaseUri());
$client = new SaungwaClient($config, $http);

$response = $client->createMessage([
    'to' => '6281234567890',
    'message' => 'Hello World!',
]);

print_r($response);
```

### Laravel 12

1. Tambahkan package:

   ```bash
   composer require your-github-username/saungwa-php:dev-master
   ```

2. Publish konfigurasi:

   ```bash
   php artisan vendor:publish --tag=saungwa-config
   ```

3. Atur di `.env`:

   ```dotenv
   SAUNGWA_APPKEY=your-appkey
   SAUNGWA_AUTHKEY=your-authkey
   SAUNGWA_SANDBOX=false
   ```

4. Contoh pemakaian (Controller):

   ```php
   use Saungwa\SaungwaClient;

   class WhatsAppController extends Controller
   {
       public function send(SaungwaClient $saungwa)
       {
           $resp = $saungwa->createMessage([
               'to' => '6281234567890',
               'message' => 'Hello Laravel 12!'
           ]);
           return response()->json($resp);
       }
   }
   ```

   Atau via **Facade**:

   ```php
   use Saungwa\Laravel\Saungwa;

   Saungwa::createMessage([
       'to' => '6281234567890',
       'message' => 'Hello Facade!'
   ]);
   ```

---

## 📂 Struktur Package

```
src/
├─ Contracts/HttpClientInterface.php
├─ Exceptions/...
├─ Http/GuzzleHttpClient.php
├─ SaungwaClient.php
├─ Config.php
└─ Laravel/
   ├─ SaungwaServiceProvider.php
   └─ Saungwa.php (Facade)
```

---

## 🧪 Testing

Library bisa diuji dengan PHPUnit.
Jalankan:

```bash
vendor/bin/phpunit
```

---

## 🤝 Kontribusi

Pull Request dan issue sangat diterima!
Pastikan code mengikuti PSR-12 dan prinsip SOLID.

---

## 📜 Lisensi

MIT License — bebas digunakan untuk project pribadi maupun komersial.
Lihat [LICENSE](LICENSE) untuk detail.

---

## 🌐 Link

* [Dokumentasi resmi Saungwa API](https://saungwa.com/api)
* [GitHub Repository](https://github.com/your-github-username/saungwa-php)

```

---

Mau saya sekalian bikinkan file **LICENSE (MIT)** juga biar repo kamu langsung siap publish?
```
