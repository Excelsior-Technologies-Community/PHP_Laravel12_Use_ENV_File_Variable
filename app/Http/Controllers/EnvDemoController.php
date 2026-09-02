<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvDemoController extends Controller
{
    public function index()
    {
        // Feature 3: Multiple Environment Support
        $currentEnv = app()->environment();

        // Feature 6: API Key Masking
        $rawKey = config('custom.api_key');
        $maskedKey = $this->maskSecret($rawKey);

        $rawSecret = config('custom.api_secret');
        $maskedSecret = $this->maskSecret($rawSecret);

        // Feature 4: Missing ENV vars (set by AppServiceProvider)
        $missingVars = config('custom.missing_env_vars', []);

        return view('env-demo', [
            // Original
            'adminEmail'    => config('custom.admin_email'),
            'supportNumber' => config('custom.support_number'),
            'appVersion'    => config('custom.app_version'),

            // Feature 1: Feature Flags
            'features'      => config('custom.features'),

            // Feature 3: Environment
            'currentEnv'    => $currentEnv,
            'envBadge'      => $this->getEnvBadge($currentEnv),

            // Feature 4: Validation
            'missingVars'   => $missingVars,

            // Feature 5: Theme
            'themeColor'    => config('custom.theme.color'),
            'themeName'     => config('custom.theme.name'),

            // Feature 6: Masked Keys
            'maskedKey'     => $maskedKey,
            'maskedSecret'  => $maskedSecret,
        ]);
    }

    // Feature 7: ENV Export Page
    public function exportEnv()
    {
        $envFile = '.env';
        $currentEnv = app()->environment();
        if (file_exists(base_path(".env.{$currentEnv}"))) {
            $envFile = ".env.{$currentEnv}";
        }

        $envVars = [
            'APP_NAME'           => config('app.name'),
            'APP_ENV'            => config('app.env'),
            'APP_VERSION'        => config('custom.app_version'),
            'ADMIN_EMAIL'        => config('custom.admin_email'),
            'SUPPORT_NUMBER'     => config('custom.support_number'),
            'FEATURE_DARK_MODE'  => config('custom.features.dark_mode') ? 'Enabled' : 'Disabled',
            'FEATURE_ANALYTICS'  => config('custom.features.analytics') ? 'Enabled' : 'Disabled',
            'FEATURE_CHAT'       => config('custom.features.chat') ? 'Enabled' : 'Disabled',
            'MAINTENANCE_MODE'   => config('custom.maintenance.enabled') ? 'Enabled' : 'Disabled',
            'APP_THEME_COLOR'    => config('custom.theme.color'),
            'APP_THEME_NAME'     => config('custom.theme.name'),
        ];

        return view('env-export', compact('envVars', 'envFile'));
    }

    // Feature 8: Cache Config Demo
    public function cacheDemo()
    {
        $isCached = file_exists(base_path('bootstrap/cache/config.php'));
        $configValue = config('custom.app_version');

        return view('cache-demo', compact('isCached', 'configValue'));
    }

    // Feature 6: Helper - mask secret string
    private function maskSecret(string $value): string
    {
        if (strlen($value) <= 6) {
            return str_repeat('*', strlen($value));
        }
        return substr($value, 0, 4) . str_repeat('*', strlen($value) - 8) . substr($value, -4);
    }

    // Feature 3: Helper - environment badge info
    private function getEnvBadge(string $env): array
    {
        return match ($env) {
            'local'      => ['class' => 'success', 'label' => 'Local'],
            'staging'    => ['class' => 'warning', 'label' => 'Staging'],
            'production' => ['class' => 'danger',  'label' => 'Production'],
            default      => ['class' => 'secondary', 'label' => ucfirst($env)],
        };
    }
}
