<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'birthdate',
        'password',
        'tipo_persona_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔹 Relaciones
    public function tipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'tipo_persona_id');
    }

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'user_id');
    }

    public function turnosComoPaciente()
    {
        return $this->hasMany(Turno::class, 'paciente_id');
    }
}