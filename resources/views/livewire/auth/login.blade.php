<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 antialiased">
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="flex justify-center mb-8">
            <x-application-logo class="w-12 h-12 text-gray-700"/>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md px-3 py-2">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600">
                        Recuérdame
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full inline-flex justify-center px-4 py-2.5 rounded-md
                               bg-gray-800 text-white font-semibold hover:bg-gray-900
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                    INICIAR SESIÓN
                </button>
            </form>
        </div>

        {{-- ✅ Link de registro visible siempre que la ruta exista --}}
        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-600 mt-4">
                ¿Nuevo por acá?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Crear cuenta</a>
            </p>
        @endif
    </div>
</div>
</body>
</html>
