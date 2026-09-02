<?php

use App\Http\Controllers\EnvDemoController;
use App\Http\Middleware\CheckMaintenanceMode;

Route::get('/', [EnvDemoController::class, 'index']);

// Feature 2: Maintenance middleware apply karyo
Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/env-demo', [EnvDemoController::class, 'index']);
    Route::get('/env-export', [EnvDemoController::class, 'exportEnv']);   // Feature 7
    Route::get('/cache-demo', [EnvDemoController::class, 'cacheDemo']);   // Feature 8
});
