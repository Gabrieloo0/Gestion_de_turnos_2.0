<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // 👉 CERRAR SESIÓN DEL USUARIO RECIÉN REGISTRADO
        Auth::guard(config('fortify.guard'))->logout();

        // Invalidar la sesión actual y regenerar el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 👉 REDIRIGIR SIEMPRE AL LOGIN CON MENSAJE
        return redirect()
            ->route('login')
            ->with('status', 'Cuenta creada correctamente. Ahora iniciá sesión.');
    }
}
