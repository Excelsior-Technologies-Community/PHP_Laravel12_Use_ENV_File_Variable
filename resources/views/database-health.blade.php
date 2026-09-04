<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Database Health | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <h2 class="fw-bold">
                🗄️ Database Health
            </h2>

            <a
                href="{{ route('config.dashboard') }}"
                class="btn btn-outline-primary">
                ← Dashboard
            </a>

        </div>


        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                @if($status === 'success')

                <div class="alert alert-success">

                    <h4>
                        ✅ Database Healthy
                    </h4>

                    <p class="mb-0">
                        {{ $message }}
                    </p>

                </div>

                @else

                <div class="alert alert-danger">

                    <h4>
                        ❌ Database Error
                    </h4>

                    <p class="mb-0">
                        {{ $message }}
                    </p>

                </div>

                @endif


                <div class="mt-4">

                    <strong>
                        Default Connection:
                    </strong>

                    <code>
                        {{ $connection }}
                    </code>

                </div>

            </div>

        </div>

    </div>

</body>

</html>