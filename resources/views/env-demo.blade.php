<!DOCTYPE html>
<html>

<head>
    <title>ENV Example | Laravel 12</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    {{-- Feature 5: Dynamic Theme Color from ENV --}}
    <style>
        :root {
            --theme-color: {
                    {
                    $themeColor
                }
            }

            ;
        }

        .card-header {
            background-color: var(--theme-color) !important;
        }

        .btn-theme {
            background-color: var(--theme-color);
            border-color: var(--theme-color);
            color: #fff;
        }

        .btn-theme:hover {
            opacity: 0.85;
            color: #fff;
        }
    </style>
    {{-- Feature 1: Dark Mode — CSS inject only when enabled --}}
    @if($features['dark_mode'])
    <style>
        body {
            background-color: #1a1a2e !important;
            color: #e0e0e0;
        }

        .card {
            background-color: #16213e;
            border-color: #0f3460;
            color: #e0e0e0;
        }

        .table {
            color: #e0e0e0;
        }
    </style>
    @endif
</head>

<body class="bg-light">

    <div class="container mt-4">

        {{-- Feature 4: Missing ENV Variables Warning --}}
        @if(!empty($missingVars))
        <div class="alert alert-danger">
            <strong>⚠️ Missing ENV Variables:</strong>
            <ul class="mb-0 mt-1">
                @foreach($missingVars as $var)
                <li><code>{{ $var }}</code> is not set in .env</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card shadow">
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">🔧 Laravel 12 — ENV Variable Demo</h4>
                {{-- Feature 3: Environment Badge --}}
                <span class="badge bg-{{ $envBadge['class'] }} fs-6">{{ $envBadge['label'] }} Environment</span>
            </div>

            <div class="card-body">

                {{-- Nav Tabs --}}
                <ul class="nav nav-tabs mb-4" id="envTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#basic">📋 Basic Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#features">🚀 Feature Flags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#theme">🎨 Theme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#api">🔑 API Keys</a>
                    </li>
                </ul>

                <div class="tab-content">

                    {{-- Tab 1: Basic Info --}}
                    <div class="tab-pane fade show active" id="basic">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Source</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>ADMIN_EMAIL</code></td>
                                    <td>{{ $adminEmail }}</td>
                                    <td><span class="badge bg-info">config()</span></td>
                                </tr>
                                <tr>
                                    <td><code>SUPPORT_NUMBER</code></td>
                                    <td>{{ $supportNumber }}</td>
                                    <td><span class="badge bg-info">config()</span></td>
                                </tr>
                                <tr>
                                    <td><code>APP_VERSION</code></td>
                                    <td><span class="badge bg-secondary">v{{ $appVersion }}</span></td>
                                    <td><span class="badge bg-info">config()</span></td>
                                </tr>
                                <tr>
                                    <td><code>APP_ENV</code></td>
                                    <td><span class="badge bg-{{ $envBadge['class'] }}">{{ $currentEnv }}</span></td>
                                    <td><span class="badge bg-warning text-dark">env()</span></td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Feature 3: Multiple Environment Info --}}
                        <div class="alert alert-info mt-3">
                            <strong>📁 Environment Files:</strong>
                            <code>.env</code> (current) |
                            <code>.env.local</code> |
                            <code>.env.staging</code> |
                            <code>.env.production</code>
                            <br><small>APP_ENV = <strong>{{ $currentEnv }}</strong> — is currently active</small>
                        </div>
                    </div>

                    {{-- Tab 2: Feature Flags (Feature 1) --}}
                    <div class="tab-pane fade" id="features">
                        <h6 class="mb-3">Feature Flags from <code>.env</code></h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ENV Variable</th>
                                    <th>Status</th>
                                    <th>Effect</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>FEATURE_DARK_MODE</code></td>
                                    <td>
                                        @if($features['dark_mode'])
                                        <span class="badge bg-success">✅ Enabled</span>
                                        @else
                                        <span class="badge bg-secondary">❌ Disabled</span>
                                        @endif
                                    </td>
                                    <td>Dark background applied to page</td>
                                </tr>
                                <tr>
                                    <td><code>FEATURE_ANALYTICS</code></td>
                                    <td>
                                        @if($features['analytics'])
                                        <span class="badge bg-success">✅ Enabled</span>
                                        @else
                                        <span class="badge bg-secondary">❌ Disabled</span>
                                        @endif
                                    </td>
                                    <td>Analytics tracking active</td>
                                </tr>
                                <tr>
                                    <td><code>FEATURE_CHAT</code></td>
                                    <td>
                                        @if($features['chat'])
                                        <span class="badge bg-success">✅ Enabled</span>
                                        @else
                                        <span class="badge bg-secondary">❌ Disabled</span>
                                        @endif
                                    </td>
                                    <td>Live chat widget shown</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Feature 1: Conditional UI based on feature flag --}}
                        @if($features['chat'])
                        <div class="alert alert-success">
                            💬 <strong>Live Chat is Active!</strong> (FEATURE_CHAT=true in .env)
                        </div>
                        @endif

                        @if($features['analytics'])
                        <div class="alert alert-primary">
                            📊 <strong>Analytics Tracking is Active!</strong> (FEATURE_ANALYTICS=true in .env)
                        </div>
                        @endif
                    </div>

                    {{-- Tab 3: Theme (Feature 5) --}}
                    <div class="tab-pane fade" id="theme">
                        <h6 class="mb-3">Dynamic Theme from <code>.env</code></h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ENV Variable</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>APP_THEME_COLOR</code></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $themeColor }}; font-size:1rem; padding: 6px 14px;">
                                            {{ $themeColor }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>APP_THEME_NAME</code></td>
                                    <td>{{ $themeName }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="p-3 rounded text-white mt-3" style="background-color: {{ $themeColor }};">
                            🎨 This box uses <strong>APP_THEME_COLOR = {{ $themeColor }}</strong> from .env
                        </div>
                    </div>

                    {{-- Tab 4: API Keys (Feature 6) --}}
                    <div class="tab-pane fade" id="api">
                        <h6 class="mb-3">API Keys — Masked from <code>.env</code></h6>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ENV Variable</th>
                                    <th>Masked Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>API_KEY</code></td>
                                    <td><code class="text-danger">{{ $maskedKey }}</code></td>
                                </tr>
                                <tr>
                                    <td><code>API_SECRET</code></td>
                                    <td><code class="text-danger">{{ $maskedSecret }}</code></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="alert alert-warning">
                            🔒 Real values are stored in <code>.env</code> — only masked format is shown in UI for security.
                        </div>
                    </div>

                </div>{{-- end tab-content --}}

                {{-- Navigation Links --}}
                <div class="mt-4 d-flex gap-2 flex-wrap">

                    <a
                        href="{{ route('env.export') }}"
                        class="btn btn-theme">
                        📤 ENV Export
                    </a>

                    <a
                        href="{{ route('cache.demo') }}"
                        class="btn btn-outline-secondary">
                        ⚡ Cache Demo
                    </a>

                    <a
                        href="{{ route('config.dashboard') }}"
                        class="btn btn-primary">
                        📊 Configuration Dashboard
                    </a>

                    <a
                        href="{{ route('config.health') }}"
                        class="btn btn-outline-primary">
                        🛡️ ENV Health Check
                    </a>

                </div>

            </div>{{-- end card-body --}}
        </div>{{-- end card --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>