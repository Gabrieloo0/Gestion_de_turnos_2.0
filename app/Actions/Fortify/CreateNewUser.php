<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'      => ['required', 'string', 'max:255'],
            // pueden venir o no; si tu BD los exige NOT NULL, les pondremos defaults abajo
            'last_name' => ['nullable','string','max:255'],
            'phone'     => ['nullable','string','max:30'],
            'birthdate' => ['nullable','date'],
            'email'     => ['required','string','email','max:255', Rule::unique(User::class)],
            'password'  => $this->passwordRules(),
        ])->validate();

        // Fallbacks para NO romper si tu BD exige NOT NULL en estos campos
        $lastName  = $input['last_name'] ?? '';                 // string vacío si no viene
        $phone     = $input['phone'] ?? '';                     // string vacío si no viene
        $birthdate = $input['birthdate'] ?? '1970-01-01';       // fecha válida por defecto

        return User::create([
            'name'      => $input['name'],
            'last_name' => $lastName,
            'phone'     => $phone,
            'birthdate' => $birthdate,
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),      // ¡IMPORTANTE!
        ]);
    }
}
