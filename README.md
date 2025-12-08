# 🚀 Laravel 12 – ENV Variable Example  


<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-f72c1f?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/ENV-Variables-green?style=for-the-badge" />
</p>

---

## 📌 Overview  
This project explains how to work with **custom .env variables**,  
how to load them using **env()**, **config()**, and how to show them in Blade.

---

## ⭐ Features  
- Custom ENV Variables  
- Custom Config File  
- env() Usage  
- config() Usage  
- Environment Mode Detection  
- Blade + Controller Integration  
- Bootstrap UI  

---

## 📁 Folder Structure  
```
app/
│── Http/
│   └── Controllers/
│       └── EnvDemoController.php
│
config/
│── custom.php
│
resources/
└── views/
    └── env-demo.blade.php

routes/
└── web.php

.env
README.md
```

---

# ✅ Step 1 — Install Laravel 12  
```bash
composer create-project laravel/laravel envdemo "12.*"
```

---

# ✅ Step 2 — Database Configuration  

📄 **.env (required settings)**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=envdemo
DB_USERNAME=root
DB_PASSWORD=
```

---

# ✅ Step 3 — Add Custom ENV Variables  
Add these at the bottom of `.env`:

```
ADMIN_EMAIL=admin@example.com
SUPPORT_NUMBER=+91-99999-99999
APP_VERSION=1.2.7
```

---

# ✅ Step 4 — Create Custom Config File  

📄 **config/custom.php**

```php
<?php

return [
    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'support_number' => env('SUPPORT_NUMBER', '+91-00000-00000'),
    'app_version' => env('APP_VERSION', '1.0'),
];
```

```
php artisan config:clear
```

---

# ⭐ Step 5 — Create Controller  

📄 **app/Http/Controllers/EnvDemoController.php**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvDemoController extends Controller
{
    public function index()
    {
        if (env('APP_ENV') == 'local') {
            echo 'Local Environment';
        }

        $adminEmail = config('custom.admin_email');
        $supportNumber = config('custom.support_number');
        $appVersion = config('custom.app_version');

        return view('env-demo', compact('adminEmail', 'supportNumber', 'appVersion'));
    }
}
```

---

# ⭐ Step 6 — Add Route  

📄 **routes/web.php**

```php
use App\Http\Controllers\EnvDemoController;

Route::get('/env-demo', [EnvDemoController::class, 'index']);
```

---

# ⭐ Step 7 — Create Blade View  

📄 **resources/views/env-demo.blade.php**

```blade
<!DOCTYPE html>
<html>
<head>
    <title>ENV Example | Laravel 12</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Laravel 12 - ENV Variable Example</h3>
        </div>

        <div class="card-body">

            <p><strong>Admin Email:</strong> {{ $adminEmail }}</p>
            <p><strong>Support Number:</strong> {{ $supportNumber }}</p>
            <p><strong>App Version:</strong> {{ $appVersion }}</p>

            @if (env('APP_ENV') == 'local')
                <div class="alert alert-info mt-3">
                    You are running in <strong>Local Environment</strong>
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
```

---

# ▶ Run Laravel Server  
```bash
php artisan serve
```

Visit:

```
http://localhost:8000/env-demo
```

---

# 🧡 ScreenShot

<img width="1392" height="357" alt="Screenshot 2025-12-08 135011" src="https://github.com/user-attachments/assets/ce1bbee6-d318-49d3-a238-62ab2264f7df" />
