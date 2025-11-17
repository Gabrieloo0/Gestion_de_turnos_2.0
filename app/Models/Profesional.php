<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $table = 'profesionales'; 
    protected $fillable = ['user_id', 'matricula'];

    public function user() { return $this->belongsTo(User::class); }

    public function especialidades()
    {
        
        return $this->belongsToMany(Especialidad::class, 'profesional_especialidad', 'profesional_id', 'especialidad_id')
                    ->withTimestamps();
    }

    public function disponibilidades()
    {
        
        return $this->hasMany(DisponibilidadProfesional::class, 'profesional_id');
    }
}
