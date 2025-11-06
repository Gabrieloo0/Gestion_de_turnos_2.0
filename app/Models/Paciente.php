<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre','apellido','dni','fecha_nacimiento','telefono','email',
        'domicilio','obra_social','nro_afiliado','observaciones',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
