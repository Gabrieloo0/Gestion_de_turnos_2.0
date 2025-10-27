<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $fillable = ['nombre_especialidad'];

    public function profesionales()
    {
        return $this->belongsToMany(Profesional::class, 'profesional_especialidad', 'especialidad_id', 'profesional_id');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'especialidad_id');
    }
}
