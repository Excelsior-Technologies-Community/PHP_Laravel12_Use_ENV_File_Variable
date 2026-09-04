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
| New Features 12-20
|--------------------------------------------------------------------------
*/

/*
| Feature 12
| Configuration Statistics
*/

Route::get('/config-stats', [
    EnvDemoController::class,
    'configStats'
])->name('config.stats');


/*
| Feature 13
| Configuration Search
*/

Route::get('/config-search', [
    EnvDemoController::class,
    'configSearch'
])->name('config.search');


/*
| Feature 14
| JSON Export
*/

Route::get('/config-export/json', [
    EnvDemoController::class,
    'exportJson'
])->name('config.export.json');


/*
| Feature 15
| CSV Export
*/

Route::get('/config-export/csv', [
    EnvDemoController::class,
    'exportCsv'
])->name('config.export.csv');


/*
| Feature 16
| System Information
*/

Route::get('/system-info', [
    EnvDemoController::class,
    'systemInfo'
])->name('system.info');


/*
| Feature 17
| Database Health
*/

Route::get('/database-health', [
    EnvDemoController::class,
    'databaseHealth'
])->name('database.health');


/*
| Feature 18
| Storage Health
*/

Route::get('/storage-health', [
    EnvDemoController::class,
    'storageHealth'
])->name('storage.health');


/*
| Feature 19
| Security Check
*/

Route::get('/security-check', [
    EnvDemoController::class,
    'securityCheck'
])->name('security.check');


/*
| Feature 20
| Configuration Snapshot
*/

Route::get('/config-snapshot', [
    EnvDemoController::class,
    'snapshot'
])->name('config.snapshot');


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
