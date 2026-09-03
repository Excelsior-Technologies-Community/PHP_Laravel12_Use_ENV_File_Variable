<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Required ENV variables.
     */
    protected array $requiredEnvVars = [
        'ADMIN_EMAIL',
        'SUPPORT_NUMBER',
        'APP_VERSION',
        'APP_THEME_COLOR',
        'API_KEY',
    ];

    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        $missing = [];

        foreach ($this->requiredEnvVars as $variable) {

            $value = env($variable);

            if ($value === null || $value === '') {
                $missing[] = $variable;
            }
        }

        config([
            'custom.missing_env_vars' => $missing,
        ]);
    }
}