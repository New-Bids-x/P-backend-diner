<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Lago Épico</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f7fafc;
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                text-align: center;
                padding: 2rem;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
            }

            h1 {
                font-size: 2.5rem;
                color: #2c3e50;
            }

            p {
                font-size: 1.25rem;
                margin-top: 1rem;
                color: #34495e;
            }

            .btn {
                margin-top: 2rem;
                padding: 1rem 2rem;
                background-color: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 600;
                transition: background-color 0.3s ease;
            }

            .btn:hover {
                background-color: #2980b9;
            }
        </style>
    @endif
</head>

<body>
    <div class="container">
        <h1>Bienvenido al backend de administración del restaurante. </h1>
        <p> Desde aquí podrás gestionar de manera eficiente
            todas las operaciones del restaurante</p>
        <a href="{{ url('/admin') }}" class="btn">Ir al Panel de Administración</a>
    </div>
</body>

</html>