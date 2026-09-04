<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Configuration Snapshot | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <div>

                <h2 class="fw-bold">
                    📸 Configuration Snapshot
                </h2>

                <p class="text-muted">
                    Current non-sensitive configuration snapshot.
                </p>

            </div>

            <a
                href="{{ route('config.dashboard') }}"
                class="btn btn-outline-primary">
                ← Dashboard
            </a>

        </div>


        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="alert alert-info">

                    <strong>
                        Generated:
                    </strong>

                    {{ $snapshot['generated_at'] }}

                </div>


                <h5 class="fw-bold mt-4">
                    Application
                </h5>

                <table class="table table-bordered">

                    <tr>

                        <th>
                            Environment
                        </th>

                        <td>
                            {{ $snapshot['environment'] }}
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Application Name
                        </th>

                        <td>
                            {{ $snapshot['application']['name'] }}
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Version
                        </th>

                        <td>
                            {{ $snapshot['application']['version'] }}
                        </td>

                    </tr>

                    <tr>

                        <th>
                            URL
                        </th>

                        <td>
                            {{ $snapshot['application']['url'] }}
                        </td>

                    </tr>

                </table>


                <h5 class="fw-bold mt-4">
                    Feature Flags
                </h5>

                <table class="table table-bordered">

                    @foreach($snapshot['features'] as $key => $value)

                    <tr>

                        <th>
                            {{ strtoupper($key) }}
                        </th>

                        <td>

                            @if($value)

                            <span class="badge bg-success">
                                Enabled
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Disabled
                            </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </table>


                <h5 class="fw-bold mt-4">
                    Theme
                </h5>

                <table class="table table-bordered">

                    <tr>

                        <th>
                            Theme Name
                        </th>

                        <td>
                            {{ $snapshot['theme']['name'] }}
                        </td>

                    </tr>

                    <tr>

                        <th>
                            Theme Color
                        </th>

                        <td>

                            <span
                                class="badge"
                                style="
                                background-color:
                                {{ $snapshot['theme']['color'] }};
                            ">
                                {{ $snapshot['theme']['color'] }}
                            </span>

                        </td>

                    </tr>

                </table>


                <h5 class="fw-bold mt-4">
                    Maintenance
                </h5>

                <div class="alert
                {{ $snapshot['maintenance']['enabled']
                    ? 'alert-danger'
                    : 'alert-success' }}">

                    @if($snapshot['maintenance']['enabled'])

                    🔧 Maintenance Mode is enabled.

                    @else

                    ✅ Maintenance Mode is disabled.

                    @endif

                    <br>

                    {{ $snapshot['maintenance']['message'] }}

                </div>


                <h5 class="fw-bold mt-4">
                    Configuration Cache
                </h5>

                @if($snapshot['cache']['configuration_cached'])

                <span class="badge bg-success">
                    ✅ Configuration Cached
                </span>

                @else

                <span class="badge bg-warning text-dark">
                    ⚠️ Configuration Not Cached
                </span>

                @endif

            </div>

        </div>

    </div>

</body>

</html>