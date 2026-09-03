<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class EnvDemoController extends Controller
{
    /**
     * Feature 1-6:
     * Main ENV Demo
     */
    public function index()
    {
        $currentEnv = app()->environment();

        $rawKey = config('custom.api_key', '');
        $maskedKey = $this->maskSecret($rawKey);

        $rawSecret = config('custom.api_secret', '');
        $maskedSecret = $this->maskSecret($rawSecret);

        $missingVars = config('custom.missing_env_vars', []);

        return view('env-demo', [
            'adminEmail' => config('custom.admin_email'),
            'supportNumber' => config('custom.support_number'),
            'appVersion' => config('custom.app_version'),

            'features' => config('custom.features', []),

            'currentEnv' => $currentEnv,
            'envBadge' => $this->getEnvBadge($currentEnv),

            'missingVars' => $missingVars,

            'themeColor' => config('custom.theme.color'),
            'themeName' => config('custom.theme.name'),

            'maskedKey' => $maskedKey,
            'maskedSecret' => $maskedSecret,
        ]);
    }

    /**
     * Feature 7:
     * ENV Export Page
     */
    public function exportEnv()
    {
        $envFile = '.env';

        $currentEnv = app()->environment();

        if (file_exists(base_path(".env.{$currentEnv}"))) {
            $envFile = ".env.{$currentEnv}";
        }

        $envVars = [
            'APP_NAME' => config('app.name'),
            'APP_ENV' => config('app.env'),
            'APP_VERSION' => config('custom.app_version'),

            'ADMIN_EMAIL' => config('custom.admin_email'),
            'SUPPORT_NUMBER' => config('custom.support_number'),

            'FEATURE_DARK_MODE' =>
                config('custom.features.dark_mode')
                    ? 'Enabled'
                    : 'Disabled',

            'FEATURE_ANALYTICS' =>
                config('custom.features.analytics')
                    ? 'Enabled'
                    : 'Disabled',

            'FEATURE_CHAT' =>
                config('custom.features.chat')
                    ? 'Enabled'
                    : 'Disabled',

            'MAINTENANCE_MODE' =>
                config('custom.maintenance.enabled')
                    ? 'Enabled'
                    : 'Disabled',

            'APP_THEME_COLOR' => config('custom.theme.color'),
            'APP_THEME_NAME' => config('custom.theme.name'),
        ];

        return view(
            'env-export',
            compact('envVars', 'envFile')
        );
    }

    /**
     * Feature 8:
     * Configuration Cache Demo
     */
    public function cacheDemo()
    {
        $isCached = file_exists(
            base_path('bootstrap/cache/config.php')
        );

        $configValue = config('custom.app_version');

        return view(
            'cache-demo',
            compact('isCached', 'configValue')
        );
    }

    /**
     * Feature 9:
     * Runtime Configuration Refresh
     */
    public function refreshConfig()
    {
        try {
            /*
            |--------------------------------------------------------------------------
            | Step 1: Clear configuration cache
            |--------------------------------------------------------------------------
            */

            Artisan::call('config:clear');

            /*
            |--------------------------------------------------------------------------
            | Step 2: Clear application cache
            |--------------------------------------------------------------------------
            */

            Artisan::call('cache:clear');

            /*
            |--------------------------------------------------------------------------
            | Step 3: Rebuild configuration cache
            |--------------------------------------------------------------------------
            */

            Artisan::call('config:cache');

            /*
            |--------------------------------------------------------------------------
            | Step 4: Get current environment
            |--------------------------------------------------------------------------
            */

            $currentEnv = app()->environment();

            /*
            |--------------------------------------------------------------------------
            | Step 5: Redirect back to dashboard
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('config.dashboard')
                ->with(
                    'success',
                    'Configuration cache refreshed successfully for '
                    . ucfirst($currentEnv)
                    . ' environment.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('config.dashboard')
                ->with(
                    'error',
                    'Configuration refresh failed: '
                    . $e->getMessage()
                );
        }
    }

    /**
     * Feature 10:
     * Configuration Dashboard
     */
    public function configDashboard()
    {
        $currentEnv = app()->environment();

        $isCached = file_exists(
            base_path('bootstrap/cache/config.php')
        );

        $features = config('custom.features', []);

        $configuration = [

            /*
            |--------------------------------------------------------------------------
            | Application
            |--------------------------------------------------------------------------
            */

            'Application' => [

                'APP_NAME' => [
                    'value' => config('app.name'),
                    'source' => 'config()',
                    'type' => 'text',
                    'sensitive' => false,
                ],

                'APP_ENV' => [
                    'value' => config('app.env'),
                    'source' => 'env() / config()',
                    'type' => 'environment',
                    'sensitive' => false,
                ],

                'APP_VERSION' => [
                    'value' => config('custom.app_version'),
                    'source' => 'custom.php',
                    'type' => 'text',
                    'sensitive' => false,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'Contact' => [

                'ADMIN_EMAIL' => [
                    'value' => config('custom.admin_email'),
                    'source' => 'custom.php',
                    'type' => 'email',
                    'sensitive' => false,
                ],

                'SUPPORT_NUMBER' => [
                    'value' => config('custom.support_number'),
                    'source' => 'custom.php',
                    'type' => 'text',
                    'sensitive' => false,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Feature Flags
            |--------------------------------------------------------------------------
            */

            'Feature Flags' => [

                'FEATURE_DARK_MODE' => [
                    'value' => $features['dark_mode'] ?? false,
                    'source' => 'custom.php',
                    'type' => 'boolean',
                    'sensitive' => false,
                ],

                'FEATURE_ANALYTICS' => [
                    'value' => $features['analytics'] ?? false,
                    'source' => 'custom.php',
                    'type' => 'boolean',
                    'sensitive' => false,
                ],

                'FEATURE_CHAT' => [
                    'value' => $features['chat'] ?? false,
                    'source' => 'custom.php',
                    'type' => 'boolean',
                    'sensitive' => false,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Theme
            |--------------------------------------------------------------------------
            */

            'Theme' => [

                'APP_THEME_COLOR' => [
                    'value' => config('custom.theme.color'),
                    'source' => 'custom.php',
                    'type' => 'color',
                    'sensitive' => false,
                ],

                'APP_THEME_NAME' => [
                    'value' => config('custom.theme.name'),
                    'source' => 'custom.php',
                    'type' => 'text',
                    'sensitive' => false,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Maintenance
            |--------------------------------------------------------------------------
            */

            'Maintenance' => [

                'MAINTENANCE_MODE' => [
                    'value' => config('custom.maintenance.enabled'),
                    'source' => 'custom.php',
                    'type' => 'boolean',
                    'sensitive' => false,
                ],

                'MAINTENANCE_MESSAGE' => [
                    'value' => config('custom.maintenance.message'),
                    'source' => 'custom.php',
                    'type' => 'text',
                    'sensitive' => false,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            'Security' => [

                'API_KEY' => [
                    'value' => $this->maskSecret(
                        config('custom.api_key', '')
                    ),
                    'source' => 'custom.php',
                    'type' => 'secret',
                    'sensitive' => true,
                ],

                'API_SECRET' => [
                    'value' => $this->maskSecret(
                        config('custom.api_secret', '')
                    ),
                    'source' => 'custom.php',
                    'type' => 'secret',
                    'sensitive' => true,
                ],
            ],
        ];

        return view(
            'config-dashboard',
            compact(
                'configuration',
                'currentEnv',
                'isCached'
            )
        );
    }

    /**
     * Feature 11:
     * ENV Configuration Health Check
     */
    public function configHealth()
    {
        $checks = [];

        /*
        |--------------------------------------------------------------------------
        | 1. Required Configuration Variables
        |--------------------------------------------------------------------------
        */

        $requiredVariables = [

            'ADMIN_EMAIL' => config('custom.admin_email'),

            'SUPPORT_NUMBER' => config(
                'custom.support_number'
            ),

            'APP_VERSION' => config(
                'custom.app_version'
            ),

            'APP_THEME_COLOR' => config(
                'custom.theme.color'
            ),

            'API_KEY' => config(
                'custom.api_key'
            ),
        ];

        foreach ($requiredVariables as $variable => $value) {

            if ($value === null || $value === '') {

                $checks[] = [
                    'name' => $variable,
                    'category' => 'Required Variable',
                    'status' => 'error',
                    'message' => 'Variable is missing or empty.',
                ];

            } else {

                $checks[] = [
                    'name' => $variable,
                    'category' => 'Required Variable',
                    'status' => 'success',
                    'message' => 'Variable is configured.',
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Boolean Configuration Variables
        |--------------------------------------------------------------------------
        */

        $booleanVariables = [

            'FEATURE_DARK_MODE' => config(
                'custom.features.dark_mode'
            ),

            'FEATURE_ANALYTICS' => config(
                'custom.features.analytics'
            ),

            'FEATURE_CHAT' => config(
                'custom.features.chat'
            ),

            'MAINTENANCE_MODE' => config(
                'custom.maintenance.enabled'
            ),
        ];

        foreach ($booleanVariables as $variable => $value) {

            $checks[] = [
                'name' => $variable,
                'category' => 'Boolean',
                'status' => 'success',
                'message' => $value
                    ? 'Boolean is enabled.'
                    : 'Boolean is disabled.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Theme Color Validation
        |--------------------------------------------------------------------------
        */

        $themeColor = config(
            'custom.theme.color'
        );

        if (
            is_string($themeColor) &&
            preg_match(
                '/^#[a-fA-F0-9]{6}$/',
                $themeColor
            )
        ) {

            $checks[] = [
                'name' => 'APP_THEME_COLOR',
                'category' => 'Theme',
                'status' => 'success',
                'message' => 'Valid hexadecimal color.',
            ];

        } else {

            $checks[] = [
                'name' => 'APP_THEME_COLOR',
                'category' => 'Theme',
                'status' => 'error',
                'message' => 'Invalid hexadecimal color format.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Application Version Validation
        |--------------------------------------------------------------------------
        */

        $version = config(
            'custom.app_version'
        );

        if (
            is_string($version) &&
            preg_match(
                '/^\d+\.\d+(\.\d+)?$/',
                $version
            )
        ) {

            $checks[] = [
                'name' => 'APP_VERSION',
                'category' => 'Application',
                'status' => 'success',
                'message' => 'Valid version format.',
            ];

        } else {

            $checks[] = [
                'name' => 'APP_VERSION',
                'category' => 'Application',
                'status' => 'warning',
                'message' =>
                    'Version should follow format such as 1.2.7.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 5. API Credentials
        |--------------------------------------------------------------------------
        */

        $apiKey = config(
            'custom.api_key',
            ''
        );

        $apiSecret = config(
            'custom.api_secret',
            ''
        );

        /*
        | API Key
        */

        if (!empty($apiKey)) {

            $checks[] = [
                'name' => 'API_KEY',
                'category' => 'Security',
                'status' => 'success',
                'message' => 'API key is configured.',
            ];

        } else {

            $checks[] = [
                'name' => 'API_KEY',
                'category' => 'Security',
                'status' => 'error',
                'message' => 'API key is missing.',
            ];
        }

        /*
        | API Secret
        */

        if (!empty($apiSecret)) {

            $checks[] = [
                'name' => 'API_SECRET',
                'category' => 'Security',
                'status' => 'success',
                'message' => 'API secret is configured.',
            ];

        } else {

            $checks[] = [
                'name' => 'API_SECRET',
                'category' => 'Security',
                'status' => 'warning',
                'message' => 'API secret is not configured.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Application Environment
        |--------------------------------------------------------------------------
        */

        $currentEnv = app()->environment();

        $validEnvironments = [
            'local',
            'staging',
            'production',
        ];

        if (
            in_array(
                $currentEnv,
                $validEnvironments,
                true
            )
        ) {

            $checks[] = [
                'name' => 'APP_ENV',
                'category' => 'Environment',
                'status' => 'success',
                'message' =>
                    "Running in {$currentEnv} environment.",
            ];

        } else {

            $checks[] = [
                'name' => 'APP_ENV',
                'category' => 'Environment',
                'status' => 'warning',
                'message' =>
                    "Unknown environment: {$currentEnv}.",
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $totalChecks = count($checks);

        $successCount = collect($checks)
            ->where('status', 'success')
            ->count();

        $warningCount = collect($checks)
            ->where('status', 'warning')
            ->count();

        $errorCount = collect($checks)
            ->where('status', 'error')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Overall Status
        |--------------------------------------------------------------------------
        */

        if ($errorCount > 0) {

            $overallStatus = 'error';

        } elseif ($warningCount > 0) {

            $overallStatus = 'warning';

        } else {

            $overallStatus = 'success';
        }

        return view(
            'config-health',
            compact(
                'checks',
                'totalChecks',
                'successCount',
                'warningCount',
                'errorCount',
                'overallStatus',
                'currentEnv'
            )
        );
    }

    /**
     * Mask sensitive values.
     */
    private function maskSecret(string $value): string
    {
        if ($value === '') {
            return 'Not configured';
        }

        if (strlen($value) <= 6) {
            return str_repeat('*', strlen($value));
        }

        return substr($value, 0, 4)
            . str_repeat(
                '*',
                max(1, strlen($value) - 8)
            )
            . substr($value, -4);
    }

    /**
     * Environment badge.
     */
    private function getEnvBadge(string $env): array
    {
        return match ($env) {

            'local' => [
                'class' => 'success',
                'label' => 'Local',
            ],

            'staging' => [
                'class' => 'warning',
                'label' => 'Staging',
            ],

            'production' => [
                'class' => 'danger',
                'label' => 'Production',
            ],

            default => [
                'class' => 'secondary',
                'label' => ucfirst($env),
            ],
        };
    }
}