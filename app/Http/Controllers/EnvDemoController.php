<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvDemoController extends Controller
{
    /**
     * Show the ENV demo page.
     * We use config('custom.*') to read values from config/custom.php
     */
    public function index()
    {
        // ENV check example (simple demonstration)
        if (env('APP_ENV') == 'local') {
            echo 'Local Environment';
        }

        // Read values from custom config file
        $adminEmail = config('custom.admin_email');
        $supportNumber = config('custom.support_number');
        $appVersion = config('custom.app_version');

        // Pass values to Blade view
        return view('env-demo', compact('adminEmail', 'supportNumber', 'appVersion'));
    }
}
