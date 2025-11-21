<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turnos';
    
    protected $fillable = [
        'paciente_id','profesional_id','servicio_id','consultorio_id',
        'fecha_turno','hora_inicio_turno','hora_fin_turno','estado_turno'
    ]; 

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function profesional()
    {
        return $this->belongsTo(Profesional::class, 'profesional_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function consultorio() {
        return $this->belongsTo(Consultorio::class, 'consultorio_id');
    }
}
