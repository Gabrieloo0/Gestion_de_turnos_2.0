<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = ['nombre_especialidad'];

    public function servicios()
    { 
        return $this->hasMany(Servicio::class, 'especialidad_id');
    }
}
