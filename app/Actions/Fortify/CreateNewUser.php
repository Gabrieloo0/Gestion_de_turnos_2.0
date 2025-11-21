<?php

namespace App\Actions\Fortify;

use App\Models\TipoPersona;
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
            'last_name' => ['nullable','string','max:255'],
            'phone'     => ['required','string','max:15'],
            'birthdate' => ['nullable','date'],
            'email'     => ['required','string','email','max:255', Rule::unique(User::class)],
            'password'  => $this->passwordRules(),
        ])->validate();

        $lastName  = $input['last_name'] ?? '';                
        $phone     = $input['phone'] ?? '';                    
        $birthdate = $input['birthdate'] ?? '1970-01-01';      

        $pacienteTipoId = TipoPersona::firstOrCreate(
            ['nombre_tipo' => 'Paciente'],
            ['created_at' => now(), 'updated_at' => now()]
        )->id;

        return User::create([
            'name'      => $input['name'],
            'last_name' => $lastName,
            'phone'     => $phone,
            'birthdate' => $birthdate,
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),
            'tipo_persona_id' => $pacienteTipoId,
        ]);
    }
}
