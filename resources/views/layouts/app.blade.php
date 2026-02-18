<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pacientes - Resultados Clínicos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-blue-900 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img class="h-16 w-auto" src="{{ asset('img/logo.png') }}" alt="Logo">
                </div>
                <div class="flex items-center">
                    @auth('web')
                    <span class="text-sm text-gray-100 mr-4">Hola, {{ Auth::guard('web')->user()->nombres }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-300 hover:text-white transition">Cerrar Sesión</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-blue-900 border-t border-blue-800 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs text-blue-200">&copy; {{ date('Y') }} Sistema de Resultados Clínicos. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>