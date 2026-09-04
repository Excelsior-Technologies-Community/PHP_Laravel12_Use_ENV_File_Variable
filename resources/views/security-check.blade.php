<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>ENV Security Check | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <div>

                <h2 class="fw-bold">
                    🔐 ENV Security Check
                </h2>

                <p class="text-muted">
                    Check important application security configuration.
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

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>Security Check</th>

                                <th>Status</th>

                                <th>Message</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($checks as $check)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <code>{{ $check['name'] }}</code>
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
                                    {{ $check['message'] }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>