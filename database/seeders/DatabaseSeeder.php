<?php

namespace Database\Seeders;

use App\Models\TipoPersona;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        $this->call([
            TipoPersonaSeeder::class,
        ]);

        $adminRoleId = TipoPersona::firstOrCreate(
            ['nombre_tipo' => 'Super Admin'],
            ['created_at' => now(), 'updated_at' => now()]
        )->id;

        User::query()->firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name'            => 'Super',
                'last_name'       => 'Administrador',
                'phone'           => null,
                'birthdate'       => null,
                'password'        => Hash::make('admin123'),
                'tipo_persona_id' => $adminRoleId,
            ]
        );
    }
}
