<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = ['turno_id', 'tipo_notificacion', 'mensaje', 'fecha_envio', 'estado_envio'];

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }
}
