<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Storage Health | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <div>

                <h2 class="fw-bold">
                    📁 Storage Health
                </h2>

                <p class="text-muted">
                    Check Laravel important directories.
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

                                <th>Directory</th>

                                <th>Path</th>

                                <th>Exists</th>

                                <th>Writable</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($checks as $check)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $check['name'] }}
                                </td>

                                <td>
                                    <code>
                                        {{ $check['path'] }}
                                    </code>
                                </td>

                                <td>

                                    @if($check['exists'])

                                    <span class="badge bg-success">
                                        ✅ Yes
                                    </span>

                                    @else

                                    <span class="badge bg-danger">
                                        ❌ No
                                    </span>

                                    @endif

                                </td>

                                <td>

                                    @if($check['writable'])

                                    <span class="badge bg-success">
                                        ✅ Writable
                                    </span>

                                    @else

                                    <span class="badge bg-danger">
                                        ❌ Not Writable
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

    </div>

</body>

</html>