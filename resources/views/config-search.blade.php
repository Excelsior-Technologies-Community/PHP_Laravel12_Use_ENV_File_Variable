<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Configuration Search | Laravel 12</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <div>

                <h2 class="fw-bold">
                    🔎 Configuration Search
                </h2>

                <p class="text-muted">
                    Search ENV and configuration variables.
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

                <form
                    method="GET"
                    action="{{ route('config.search') }}"
                    class="mb-4">

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            class="form-control"
                            placeholder="Search APP_NAME, API_KEY, FEATURE...">

                        <button class="btn btn-primary">
                            🔎 Search
                        </button>

                        <a
                            href="{{ route('config.search') }}"
                            class="btn btn-outline-secondary">
                            Clear
                        </a>

                    </div>

                </form>


                @if(count($configuration) > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>Variable</th>

                                <th>Value</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($configuration as $key => $value)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <code>{{ $key }}</code>
                                </td>

                                <td>
                                    {{ $value }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @else

                <div class="alert alert-warning">
                    No configuration variable found.
                </div>

                @endif

            </div>

        </div>

    </div>

</body>

</html>