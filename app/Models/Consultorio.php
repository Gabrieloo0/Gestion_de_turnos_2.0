<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $fillable = ['nombre_consultorio', 'descripcion'];

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'consultorio_id');
    }
}
