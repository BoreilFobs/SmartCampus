<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartCampus') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                font-family: 'Figtree', sans-serif;
            }
            .min-vh-100 {
                min-height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
            <!-- Logo/Branding -->
            <div class="text-center mb-4">
                <h1 class="display-6 fw-bold text-white mb-2">🎓 SmartCampus</h1>
                <p class="text-white-50">Educational Platform</p>
            </div>

            <!-- Card Container -->
            <div class="card shadow-lg w-100" style="max-width: 450px; border: none;">
                <div class="card-body p-5">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 text-white-50">
                <p class="small mb-0">&copy; 2025 SmartCampus. All rights reserved.</p>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
