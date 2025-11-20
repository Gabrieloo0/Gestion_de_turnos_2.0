<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 antialiased font-sans">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <x-application-logo class="w-48 h-auto mb-2 animate-fade-slide" />
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-md border-gray-300 focus:border-blue-600 focus:ring-blue-600">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-md border-gray-300 focus:border-blue-600 focus:ring-blue-600">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Contraseña</label>
                    <input type="password" name="password" required
                        class="w-full rounded-md border-gray-300 focus:border-blue-600 focus:ring-blue-600">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-md border-gray-300 focus:border-blue-600 focus:ring-blue-600">
                    @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full inline-flex justify-center px-4 py-2.5 rounded-md
                               hover:bg-primaryDark text-white font-semibold bg-primary
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    Registrarse
                </button>
            </form>
        </div>
        <p class="text-center text-sm text-gray-600 mt-4">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciar sesión</a>
        </p>
    </div>
</div>
</body>
</html>

{{-- <!DOCTYPE html> <html lang="es"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Crear cuenta</title> @vite(['resources/css/app.css','resources/js/app.js']) </head> <body class="min-h-screen bg-gray-100 antialiased"> <div class="min-h-screen flex items-center justify-center px-4"> <div class="w-full max-w-md"> <div class="flex justify-center mb-8"> <x-application-logo class="w-12 h-12 text-gray-700"/> </div> <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm"> <form method="POST" action="{{ route('register') }}" class="space-y-4"> @csrf <div> <label class="block text-sm text-gray-700 mb-1">Nombre completo</label> <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"> @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror </div> <div> <label class="block text-sm text-gray-700 mb-1">Correo electrónico</label> <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"> @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror </div> <div> <label class="block text-sm text-gray-700 mb-1">Contraseña</label> <input type="password" name="password" required class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"> @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror </div> <div> <label class="block text-sm text-gray-700 mb-1">Confirmar contraseña</label> <input type="password" name="password_confirmation" required class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"> @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror </div> <button type="submit" class="w-full inline-flex justify-center px-4 py-2.5 rounded-md bg-gray-800 text-white font-semibold hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800"> CREAR CUENTA </button> </form> </div> <p class="text-center text-sm text-gray-600 mt-4"> ¿Ya tenés cuenta? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Iniciar sesión</a> </p> </div> </div> </body> </html> --}}
