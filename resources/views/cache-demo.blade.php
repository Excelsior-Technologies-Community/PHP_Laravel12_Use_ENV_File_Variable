<!DOCTYPE html>
<html>

<head>
    <title>Cache Demo | Laravel 12</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">⚡ Config Cache Demo</h5>
                <a
                    href="{{ route('env.demo') }}"
                    class="btn btn-sm btn-outline-light">
                    ← Back
                </a>
            </div>
            <div class="card-body">

                {{-- Cache Status --}}
                <div class="alert {{ $isCached ? 'alert-success' : 'alert-warning' }}">
                    @if($isCached)
                    ✅ <strong>Config is CACHED</strong> — <code>bootstrap/cache/config.php</code> exists.
                    <br><small>ENV changes won't reflect until you run <code>php artisan config:clear</code></small>
                    @else
                    ⚠️ <strong>Config is NOT cached</strong> — reading directly from <code>.env</code> file.
                    <br><small>Run <code>php artisan config:cache</code> to cache for production.</small>
                    @endif
                </div>

                {{-- Current Config Value --}}
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Config Key</th>
                            <th>Current Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>config('custom.app_version')</code></td>
                            <td><span class="badge bg-primary">v{{ $configValue }}</span></td>
                        </tr>
                    </tbody>
                </table>

                {{-- Commands Reference --}}
                <h6 class="mt-4">📋 Useful Artisan Commands:</h6>
                <table class="table table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Command</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>php artisan config:cache</code></td>
                            <td>Cache all config files — faster for production</td>
                        </tr>
                        <tr>
                            <td><code>php artisan config:clear</code></td>
                            <td>Clear config cache — required after .env changes</td>
                        </tr>
                        <tr>
                            <td><code>php artisan config:show custom</code></td>
                            <td>Show all values from config/custom.php</td>
                        </tr>
                        <tr>
                            <td><code>php artisan env</code></td>
                            <td>Show current APP_ENV value</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Configuration Navigation --}}
                <div class="mt-4 d-flex gap-2 flex-wrap">

                    <a
                        href="{{ route('config.dashboard') }}"
                        class="btn btn-primary">
                        📊 Configuration Dashboard
                    </a>

                    <a
                        href="{{ route('config.health') }}"
                        class="btn btn-outline-primary">
                        🛡️ Health Check
                    </a>

                </div>
            </div>
        </div>
    </div>
</body>

</html>