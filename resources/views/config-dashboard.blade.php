<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Configuration Dashboard | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >

    <style>

        body {
            background: #f4f6f9;
        }

        .dashboard-card {
            border: none;
            border-radius: 16px;
        }

        .section-title {
            font-weight: 700;
        }

        .config-value {
            font-family: monospace;
            font-size: 0.9rem;
        }

        .source-badge {
            font-size: 0.75rem;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            display: inline-block;
            border-radius: 50%;
            margin-right: 6px;
        }

        .dot-success {
            background: #198754;
        }

        .dot-warning {
            background: #ffc107;
        }

        .dot-danger {
            background: #dc3545;
        }

    </style>

</head>

<body>

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                📊 Configuration Dashboard
            </h2>

            <p class="text-muted mb-0">
                Monitor Laravel ENV and configuration values.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('env.demo') }}"
                class="btn btn-outline-secondary"
            >
                ← ENV Demo
            </a>

            <a
                href="{{ route('config.health') }}"
                class="btn btn-outline-primary"
            >
                🛡️ Health Check
            </a>

        </div>

    </div>


    {{-- Flash Messages --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            ✅ {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            ❌ {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- Environment Summary --}}

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        CURRENT ENVIRONMENT
                    </small>

                    <h3 class="mt-2 mb-0">

                        @if($currentEnv === 'production')

                            <span class="badge bg-danger">
                                🔴 Production
                            </span>

                        @elseif($currentEnv === 'staging')

                            <span class="badge bg-warning text-dark">
                                🟡 Staging
                            </span>

                        @else

                            <span class="badge bg-success">
                                🟢 {{ ucfirst($currentEnv) }}
                            </span>

                        @endif

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        CONFIGURATION CACHE
                    </small>

                    <h3 class="mt-2">

                        @if($isCached)

                            <span class="text-success">
                                ✅ Cached
                            </span>

                        @else

                            <span class="text-warning">
                                ⚠️ Not Cached
                            </span>

                        @endif

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card dashboard-card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        CONFIG SOURCE
                    </small>

                    <h3 class="mt-2">

                        <span class="badge bg-info">
                            .env → config()
                        </span>

                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Refresh Configuration --}}

    <div class="card dashboard-card shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h5 class="fw-bold">
                        🔄 Refresh Configuration
                    </h5>

                    <p class="text-muted mb-0">
                        Clear the existing Laravel configuration cache
                        and rebuild it using the current environment values.
                    </p>

                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <form
                        action="{{ route('config.refresh') }}"
                        method="POST"
                        id="refreshConfigForm"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="refreshConfigButton"
                        >
                            🔄 Refresh & Cache
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- Configuration Sections --}}

    @foreach($configuration as $section => $variables)

        <div class="card dashboard-card shadow-sm mb-4">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="section-title mb-0">
                    {{ $section }}
                </h5>

            </div>

            <div class="card-body px-4">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                        <tr>

                            <th>
                                ENV Variable
                            </th>

                            <th>
                                Value
                            </th>

                            <th>
                                Source
                            </th>

                            <th>
                                Type
                            </th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($variables as $key => $item)

                            <tr>

                                <td>
                                    <code>
                                        {{ $key }}
                                    </code>
                                </td>

                                <td>

                                    @if($item['type'] === 'boolean')

                                        @if($item['value'])

                                            <span class="badge bg-success">
                                                Enabled
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Disabled
                                            </span>

                                        @endif

                                    @elseif($item['type'] === 'color')

                                        <span
                                            class="badge"
                                            style="
                                                background-color:
                                                {{ $item['value'] }};
                                                font-size: 0.9rem;
                                            "
                                        >
                                            {{ $item['value'] }}
                                        </span>

                                    @elseif($item['type'] === 'secret')

                                        <code class="text-danger">
                                            🔒 {{ $item['value'] }}
                                        </code>

                                    @else

                                        <span class="config-value">
                                            {{ $item['value'] }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-info source-badge">
                                        {{ $item['source'] }}
                                    </span>

                                </td>

                                <td>

                                    @switch($item['type'])

                                        @case('boolean')
                                            <span class="badge bg-secondary">
                                                Boolean
                                            </span>
                                            @break

                                        @case('secret')
                                            <span class="badge bg-danger">
                                                Sensitive
                                            </span>
                                            @break

                                        @case('color')
                                            <span class="badge bg-primary">
                                                Color
                                            </span>
                                            @break

                                        @case('environment')
                                            <span class="badge bg-warning text-dark">
                                                Environment
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-light text-dark">
                                                Text
                                            </span>

                                    @endswitch

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endforeach


    {{-- Bottom Navigation --}}

    <div class="d-flex justify-content-center gap-2">

        <a
            href="{{ route('env.export') }}"
            class="btn btn-dark"
        >
            📤 ENV Export
        </a>

        <a
            href="{{ route('cache.demo') }}"
            class="btn btn-outline-secondary"
        >
            ⚡ Cache Demo
        </a>

        <a
            href="{{ route('config.health') }}"
            class="btn btn-outline-primary"
        >
            🛡️ Configuration Health
        </a>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document
    .getElementById('refreshConfigForm')
    ?.addEventListener('submit', function (event) {

        const button = document.getElementById(
            'refreshConfigButton'
        );

        const confirmed = confirm(
            'Refresh Laravel configuration cache using the current ENV values?'
        );

        if (!confirmed) {
            event.preventDefault();
            return;
        }

        button.disabled = true;

        button.innerHTML = '⏳ Refreshing...';
    });
</script>

</body>
</html>