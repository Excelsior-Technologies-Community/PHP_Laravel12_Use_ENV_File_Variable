<!DOCTYPE html>
<html>
<head>
    <title>ENV Export | Laravel 12</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📤 ENV Variable Export (Non-Sensitive)</h5>
            <a href="/env-demo" class="btn btn-sm btn-outline-light">← Back</a>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0">All custom ENV variables — sensitive values (API keys/secrets) are excluded.</p>
                <span class="badge bg-info">Active: <code>{{ $envFile }}</code></span>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Variable Name</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($envVars as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $key }}</code></td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
