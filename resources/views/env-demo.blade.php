<!DOCTYPE html>
<html>
<head>
    <title>ENV Example | Laravel 12</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Laravel 12 - ENV Variable Example</h3>
        </div>

        <div class="card-body">

            <p><strong>Admin Email:</strong> {{ $adminEmail }}</p>
            <p><strong>Support Number:</strong> {{ $supportNumber }}</p>
            <p><strong>App Version:</strong> {{ $appVersion }}</p>

            <!-- 🔥 env() check added here -->
            @if (env('APP_ENV') == 'local')
                <div class="alert alert-info mt-3">
                    You are running in <strong>Local Environment</strong>
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
