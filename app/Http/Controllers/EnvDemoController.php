<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EnvDemoController extends Controller
{
    /**
     * ================================================================
     * Feature 1-6
     * Main ENV Demo
     * ================================================================
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
     * ================================================================
     * Feature 7
     * ENV Export Page
     * ================================================================
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
     * ================================================================
     * Feature 8
     * Configuration Cache Demo
     * ================================================================
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
     * ================================================================
     * Feature 9
     * Runtime Configuration Refresh
     * ================================================================
     */
    public function refreshConfig()
    {
        try {
            Artisan::call('config:clear');

            Artisan::call('cache:clear');

            Artisan::call('config:cache');

            $currentEnv = app()->environment();

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
     * ================================================================
     * Feature 10
     * Configuration Dashboard
     * ================================================================
     */
    public function configDashboard()
    {
        $currentEnv = app()->environment();

        $isCached = file_exists(
            base_path('bootstrap/cache/config.php')
        );

        $features = config('custom.features', []);

        $configuration = [

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
     * ================================================================
     * Feature 11
     * ENV Configuration Health Check
     * ================================================================
     */
    public function configHealth()
    {
        $checks = [];

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

        $apiKey = config(
            'custom.api_key',
            ''
        );

        $apiSecret = config(
            'custom.api_secret',
            ''
        );

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
     * ================================================================
     * Feature 12
     * Configuration Statistics
     * ================================================================
     */
    public function configStats()
    {
        $features = config('custom.features', []);

        $statistics = [
            'total_features' => count($features),
            'enabled_features' => collect($features)
                ->filter(fn($value) => $value === true)
                ->count(),
            'disabled_features' => collect($features)
                ->filter(fn($value) => $value === false)
                ->count(),

            'maintenance' =>
            config('custom.maintenance.enabled')
                ? 'Enabled'
                : 'Disabled',

            'api_key' =>
            !empty(config('custom.api_key'))
                ? 'Configured'
                : 'Missing',

            'api_secret' =>
            !empty(config('custom.api_secret'))
                ? 'Configured'
                : 'Missing',

            'configuration_cached' =>
            file_exists(
                base_path('bootstrap/cache/config.php')
            ),
        ];

        return view(
            'config-stats',
            compact('statistics')
        );
    }

    /**
     * ================================================================
     * Feature 13
     * Configuration Search
     * ================================================================
     */
    public function configSearch(Request $request)
    {
        $search = trim(
            $request->get('search', '')
        );

        $configuration = [

            'APP_NAME' => config('app.name'),

            'APP_ENV' => config('app.env'),

            'APP_VERSION' => config(
                'custom.app_version'
            ),

            'ADMIN_EMAIL' => config(
                'custom.admin_email'
            ),

            'SUPPORT_NUMBER' => config(
                'custom.support_number'
            ),

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

            'APP_THEME_COLOR' => config(
                'custom.theme.color'
            ),

            'APP_THEME_NAME' => config(
                'custom.theme.name'
            ),

            'API_KEY' => $this->maskSecret(
                config('custom.api_key', '')
            ),

            'API_SECRET' => $this->maskSecret(
                config('custom.api_secret', '')
            ),
        ];

        if ($search !== '') {

            $configuration = collect($configuration)
                ->filter(function ($value, $key) use ($search) {

                    return str_contains(
                        strtolower($key),
                        strtolower($search)
                    );
                })
                ->toArray();
        }

        return view(
            'config-search',
            compact(
                'configuration',
                'search'
            )
        );
    }

    /**
     * ================================================================
     * Feature 14
     * JSON Export
     * ================================================================
     */
    public function exportJson()
    {
        $data = $this->getSafeExportData();

        return response()->json(
            $data,
            200,
            [
                'Content-Disposition' =>
                'attachment; filename="env-config.json"',
            ]
        );
    }

    /**
     * ================================================================
     * Feature 15
     * CSV Export
     * ================================================================
     */
    public function exportCsv()
    {
        $data = $this->getSafeExportData();

        return response()->streamDownload(function () use ($data) {

            $handle = fopen('php://output', 'w');

            fputcsv(
                $handle,
                ['Variable', 'Value']
            );

            foreach ($data as $key => $value) {

                fputcsv(
                    $handle,
                    [$key, $value]
                );
            }

            fclose($handle);
        }, 'env-config.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * ================================================================
     * Feature 16
     * System Information
     * ================================================================
     */
    public function systemInfo()
    {
        $information = [

            'Laravel Version' => app()->version(),

            'PHP Version' => PHP_VERSION,

            'Environment' => app()->environment(),

            'Application Name' => config('app.name'),

            'Application URL' => config('app.url'),

            'Timezone' => config('app.timezone'),

            'Locale' => config('app.locale'),

            'Debug Mode' =>
            config('app.debug')
                ? 'Enabled'
                : 'Disabled',

            'Operating System' => PHP_OS,

            'Server Software' =>
            $_SERVER['SERVER_SOFTWARE']
                ?? 'Unknown',

            'Configuration Cache' =>
            file_exists(
                base_path('bootstrap/cache/config.php')
            )
                ? 'Enabled'
                : 'Disabled',
        ];

        return view(
            'system-info',
            compact('information')
        );
    }

    /**
     * ================================================================
     * Feature 17
     * Database Health Check
     * ================================================================
     */
    public function databaseHealth()
    {
        $status = 'success';

        $message = 'Database connection is working.';

        $connection = config(
            'database.default'
        );

        try {

            DB::connection()->getPdo();
        } catch (\Throwable $e) {

            $status = 'error';

            $message = 'Database connection failed.';
        }

        return view(
            'database-health',
            compact(
                'status',
                'message',
                'connection'
            )
        );
    }

    /**
     * ================================================================
     * Feature 18
     * Storage Health Check
     * ================================================================
     */
    public function storageHealth()
    {
        $paths = [

            'Storage Directory' =>
            storage_path(),

            'Storage App Directory' =>
            storage_path('app'),

            'Storage Logs Directory' =>
            storage_path('logs'),

            'Bootstrap Cache Directory' =>
            base_path('bootstrap/cache'),

            'Public Directory' =>
            public_path(),
        ];

        $checks = [];

        foreach ($paths as $name => $path) {

            $exists = File::exists($path);

            $writable = $exists
                ? is_writable($path)
                : false;

            $checks[] = [

                'name' => $name,

                'path' => $path,

                'exists' => $exists,

                'writable' => $writable,
            ];
        }

        return view(
            'storage-health',
            compact('checks')
        );
    }

    /**
     * ================================================================
     * Feature 19
     * ENV Security Check
     * ================================================================
     */
    public function securityCheck()
    {
        $checks = [];

        $envPath = base_path('.env');

        $checks[] = [

            'name' => '.env File Exists',

            'status' => file_exists($envPath)
                ? 'success'
                : 'warning',

            'message' => file_exists($envPath)
                ? '.env file exists.'
                : '.env file was not found.',
        ];

        $checks[] = [

            'name' => 'APP_DEBUG',

            'status' => config('app.debug')
                ? 'warning'
                : 'success',

            'message' => config('app.debug')
                ? 'Debug mode is enabled.'
                : 'Debug mode is disabled.',
        ];

        $checks[] = [

            'name' => 'APP_KEY',

            'status' => !empty(config('app.key'))
                ? 'success'
                : 'error',

            'message' => !empty(config('app.key'))
                ? 'Application key is configured.'
                : 'Application key is missing.',
        ];

        $checks[] = [

            'name' => 'API_KEY',

            'status' => !empty(config('custom.api_key'))
                ? 'success'
                : 'warning',

            'message' => !empty(config('custom.api_key'))
                ? 'API key is configured.'
                : 'API key is missing.',
        ];

        $checks[] = [

            'name' => 'API_SECRET',

            'status' => !empty(config('custom.api_secret'))
                ? 'success'
                : 'warning',

            'message' => !empty(config('custom.api_secret'))
                ? 'API secret is configured.'
                : 'API secret is missing.',
        ];

        return view(
            'security-check',
            compact('checks')
        );
    }

    /**
     * ================================================================
     * Feature 20
     * Configuration Snapshot
     * ================================================================
     */
    public function snapshot()
    {
        $snapshot = [

            'generated_at' => now()->format(
                'Y-m-d H:i:s'
            ),

            'environment' => app()->environment(),

            'application' => [

                'name' => config('app.name'),

                'version' => config(
                    'custom.app_version'
                ),

                'url' => config('app.url'),

            ],

            'features' => config(
                'custom.features',
                []
            ),

            'theme' => [

                'name' => config(
                    'custom.theme.name'
                ),

                'color' => config(
                    'custom.theme.color'
                ),

            ],

            'maintenance' => [

                'enabled' => config(
                    'custom.maintenance.enabled'
                ),

                'message' => config(
                    'custom.maintenance.message'
                ),

            ],

            'cache' => [

                'configuration_cached' =>
                file_exists(
                    base_path(
                        'bootstrap/cache/config.php'
                    )
                ),
            ],
        ];

        return view(
            'config-snapshot',
            compact('snapshot')
        );
    }

    /**
     * ================================================================
     * Safe Export Data
     * ================================================================
     */
    private function getSafeExportData(): array
    {
        return [

            'APP_NAME' => config('app.name'),

            'APP_ENV' => config('app.env'),

            'APP_VERSION' => config(
                'custom.app_version'
            ),

            'ADMIN_EMAIL' => config(
                'custom.admin_email'
            ),

            'SUPPORT_NUMBER' => config(
                'custom.support_number'
            ),

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

            'APP_THEME_COLOR' => config(
                'custom.theme.color'
            ),

            'APP_THEME_NAME' => config(
                'custom.theme.name'
            ),
        ];
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
