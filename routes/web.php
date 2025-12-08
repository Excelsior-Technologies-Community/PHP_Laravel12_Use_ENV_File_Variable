<?php

use App\Http\Controllers\EnvDemoController;

Route::get('/env-demo', [EnvDemoController::class, 'index']);
