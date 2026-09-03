<?php

use App\Http\Controllers\EnvDemoController;
use App\Http\Middleware\CheckMaintenanceMode;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Main ENV Demo
|--------------------------------------------------------------------------
*/

Route::get('/', [
    EnvDemoController::class,
    'index'
])->name('env.demo');

/*
|--------------------------------------------------------------------------
| Configuration Management
|--------------------------------------------------------------------------
|
| Keep these outside maintenance middleware so the administrator can
| inspect and manage configuration even when maintenance mode is enabled.
|
*/

Route::get('/config-dashboard', [
    EnvDemoController::class,
    'configDashboard'
])->name('config.dashboard');

Route::post('/config-refresh', [
    EnvDemoController::class,
    'refreshConfig'
])->name('config.refresh');

Route::get('/config-health', [
    EnvDemoController::class,
    'configHealth'
])->name('config.health');

/*
|--------------------------------------------------------------------------
| Existing Features
|--------------------------------------------------------------------------
*/

Route::middleware([
    CheckMaintenanceMode::class
])->group(function () {

    Route::get('/env-demo', [
        EnvDemoController::class,
        'index'
    ])->name('env.demo.page');

    Route::get('/env-export', [
        EnvDemoController::class,
        'exportEnv'
    ])->name('env.export');

    Route::get('/cache-demo', [
        EnvDemoController::class,
        'cacheDemo'
    ])->name('cache.demo');
});