<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = ['nombre_servicio', 'duracion_estimada', 'requiere_consultorio', 'especialidad_id'];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'servicio_id');
    }
}
