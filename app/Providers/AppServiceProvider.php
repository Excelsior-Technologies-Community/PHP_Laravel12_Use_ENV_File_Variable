<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Feature 4: Required ENV variables list
    protected array $requiredEnvVars = [
        'ADMIN_EMAIL',
        'SUPPORT_NUMBER',
        'APP_VERSION',
        'APP_THEME_COLOR',
        'API_KEY',
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Feature 3: Multiple Environment Support - Load env-specific file
        $this->loadEnvironmentFile();

        // Feature 4: ENV Variable Validation
        $missing = [];
        foreach ($this->requiredEnvVars as $var) {
            if (!$this->isEnvSet($var)) {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            config(['custom.missing_env_vars' => $missing]);
        }
    }

    private function loadEnvironmentFile(): void
    {
        $env = app()->environment();
        $envFile = base_path(".env.{$env}");

        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (empty($key)) {
                continue;
            }

            $currentEnvValue = env($key);
            if ($currentEnvValue === null || $currentEnvValue === '') {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }

    private function isEnvSet(string $key): bool
    {
        $envFiles = [base_path('.env')];

        $env = app()->environment();
        $envSpecificFile = base_path(".env.{$env}");
        if (file_exists($envSpecificFile)) {
            $envFiles[] = $envSpecificFile;
        }

        foreach ($envFiles as $envFile) {
            if (!file_exists($envFile)) {
                continue;
            }

            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (str_starts_with($trimmed, '#') || !str_contains($trimmed, '=')) {
                    continue;
                }
                [$currentKey] = explode('=', $trimmed, 2);
                if (trim($currentKey) === $key) {
                    return true;
                }
            }
        }

        return false;
    }
}

