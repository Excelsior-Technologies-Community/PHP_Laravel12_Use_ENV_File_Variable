<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Configuration Statistics | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
        }

        .number {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">
                    📊 Configuration Statistics
                </h2>

                <p class="text-muted">
                    Overview of the current ENV configuration.
                </p>

            </div>

            <a
                href="{{ route('config.dashboard') }}"
                class="btn btn-outline-primary">
                ← Dashboard
            </a>

        </div>


        <div class="row g-4">

            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <small class="text-muted">
                            TOTAL FEATURES
                        </small>

                        <div class="number">
                            {{ $statistics['total_features'] }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <small class="text-muted">
                            ENABLED FEATURES
                        </small>

                        <div class="number text-success">
                            {{ $statistics['enabled_features'] }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <small class="text-muted">
                            DISABLED FEATURES
                        </small>

                        <div class="number text-secondary">
                            {{ $statistics['disabled_features'] }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <h6>Maintenance Mode</h6>

                        <span class="badge
                        {{ $statistics['maintenance'] === 'Enabled'
                            ? 'bg-danger'
                            : 'bg-success' }}">

                            {{ $statistics['maintenance'] }}

                        </span>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <h6>API Key</h6>

                        <span class="badge
                        {{ $statistics['api_key'] === 'Configured'
                            ? 'bg-success'
                            : 'bg-danger' }}">

                            {{ $statistics['api_key'] }}

                        </span>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card stat-card shadow-sm">

                    <div class="card-body">

                        <h6>Configuration Cache</h6>

                        <span class="badge
                        {{ $statistics['configuration_cached']
                            ? 'bg-success'
                            : 'bg-warning text-dark' }}">

                            {{ $statistics['configuration_cached']
                            ? 'Cached'
                            : 'Not Cached' }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>