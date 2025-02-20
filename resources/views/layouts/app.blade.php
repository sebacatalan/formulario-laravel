<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Turismo')</title>

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <header class="header">
        <nav class="nav">
            <ul class="nav-list">
                <li><a href="{{ route('formulario.index') }}" class="nav-link">Inicio</a></li>
                <li class="logout-form">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    
    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Turismo. Todos los derechos reservados.</p>
    </footer>

    @yield('scripts')
</body>

</html>