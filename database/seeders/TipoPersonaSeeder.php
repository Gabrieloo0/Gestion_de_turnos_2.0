<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPersonaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Paciente','Profesional','Super Admin'] as $t) {
            DB::table('tipo_persona')->updateOrInsert(
                ['nombre_tipo' => $t],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
