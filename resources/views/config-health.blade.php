<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Configuration Health | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >

    <style>

        body {
            background: #f4f6f9;
        }

        .health-card {
            border: none;
            border-radius: 16px;
        }

        .summary-number {
            font-size: 2rem;
            font-weight: 700;
        }

        .check-icon {
            font-size: 1.3rem;
        }

    </style>

</head>

<body>

<div class="container py-5">

    {{-- Header --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                🛡️ ENV Configuration Health
            </h2>

            <p class="text-muted mb-0">
                Validate environment variables and application configuration.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('config.dashboard') }}"
                class="btn btn-outline-primary"
            >
                📊 Dashboard
            </a>

            <a
                href="{{ route('env.demo') }}"
                class="btn btn-outline-secondary"
            >
                ← ENV Demo
            </a>

        </div>

    </div>


    {{-- Overall Status --}}

    @if($overallStatus === 'success')

        <div class="alert alert-success shadow-sm">

            <strong>✅ Configuration Healthy</strong>

            <br>

            All configuration checks passed successfully.

        </div>

    @elseif($overallStatus === 'warning')

        <div class="alert alert-warning shadow-sm">

            <strong>⚠️ Configuration Has Warnings</strong>

            <br>

            Some configuration values should be reviewed.

        </div>

    @else

        <div class="alert alert-danger shadow-sm">

            <strong>❌ Configuration Has Errors</strong>

            <br>

            One or more configuration problems require attention.

        </div>

    @endif


    {{-- Summary --}}

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card health-card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        TOTAL CHECKS
                    </small>

                    <div class="summary-number">
                        {{ $totalChecks }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card health-card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        PASSED
                    </small>

                    <div class="summary-number text-success">
                        {{ $successCount }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card health-card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        WARNINGS
                    </small>

                    <div class="summary-number text-warning">
                        {{ $warningCount }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card health-card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        ERRORS
                    </small>

                    <div class="summary-number text-danger">
                        {{ $errorCount }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Current Environment --}}

    <div class="card health-card shadow-sm mb-4">

        <div class="card-body">

            <strong>
                Current Environment:
            </strong>

            <span class="badge bg-primary">
                {{ ucfirst($currentEnv) }}
            </span>

        </div>

    </div>


    {{-- Health Checks --}}

    <div class="card health-card shadow-sm">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                🔍 Configuration Checks
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0 align-middle">

                    <thead>

                    <tr>

                        <th class="ps-4">
                            #
                        </th>

                        <th>
                            Variable
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Message
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($checks as $check)

                        <tr>

                            <td class="ps-4">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <code>
                                    {{ $check['name'] }}
                                </code>
                            </td>

                            <td>
                                {{ $check['category'] }}
                            </td>

                            <td>

                                @if($check['status'] === 'success')

                                    <span class="badge bg-success">
                                        ✅ Passed
                                    </span>

                                @elseif($check['status'] === 'warning')

                                    <span class="badge bg-warning text-dark">
                                        ⚠️ Warning
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        ❌ Error
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($check['status'] === 'success')

                                    <span class="text-success">
                                        {{ $check['message'] }}
                                    </span>

                                @elseif($check['status'] === 'warning')

                                    <span class="text-warning">
                                        {{ $check['message'] }}
                                    </span>

                                @else

                                    <span class="text-danger">
                                        {{ $check['message'] }}
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <div class="text-center mt-4">

        <a
            href="{{ route('config.dashboard') }}"
            class="btn btn-primary"
        >
            ← Back to Configuration Dashboard
        </a>

    </div>

</div>

</body>
</html>