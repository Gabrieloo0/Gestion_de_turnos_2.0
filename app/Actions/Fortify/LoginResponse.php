<?php

namespace App\Actions\Fortify;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        return redirect()->intended($this->redirectPathFor($user));
    }

    protected function redirectPathFor($user): string
    {
        if ($user && $user->hasRole('Paciente')) {
            return route('welcome');
        }

        if ($user && $user->hasRole('Super Admin', 'Profesional')) {
            return route('dashboard');
        }

        return route('dashboard');
    }
}

