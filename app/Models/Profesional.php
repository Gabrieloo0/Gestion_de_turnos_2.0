<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $fillable = ['user_id', 'matricula'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'profesional_especialidad', 'profesional_id', 'especialidad_id');
    }

    public function disponibilidades()
    {
        return $this->hasMany(DisponibilidadProfesional::class, 'profesional_id');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'profesional_id');
    }
}
