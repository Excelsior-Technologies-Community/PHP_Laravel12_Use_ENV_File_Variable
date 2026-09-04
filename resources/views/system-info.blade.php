<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>System Information | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <div>

                <h2 class="fw-bold">
                    💻 System Information
                </h2>

                <p class="text-muted">
                    Laravel and server environment information.
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

                                <th>
                                    Information
                                </th>

                                <th>
                                    Value
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($information as $key => $value)

                            <tr>

                                <td>
                                    <strong>{{ $key }}</strong>
                                </td>

                                <td>
                                    <code>{{ $value }}</code>
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