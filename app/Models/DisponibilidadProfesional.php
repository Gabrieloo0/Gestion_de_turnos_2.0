<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibilidadProfesional extends Model
{
    protected $table = 'disponibilidad_profesional';

    protected $fillable = ['profesional_id', 'dia_semana', 'hora_inicio', 'hora_fin'];

    public function profesional()
    {
        return $this->belongsTo(Profesional::class, 'profesional_id');
    }
}
