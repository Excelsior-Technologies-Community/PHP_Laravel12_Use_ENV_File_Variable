<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        if (config('custom.maintenance.enabled') === true) {
            return response()->view('maintenance', [
                'message' => config('custom.maintenance.message'),
            ], 503);
        }

        return $next($request);
    }
}
