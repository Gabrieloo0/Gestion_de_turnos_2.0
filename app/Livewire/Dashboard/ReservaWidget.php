<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Profesional;
use App\Models\Especialidad;
use App\Models\Servicio;
use App\Models\Consultorio;
use App\Models\Turno;
use App\Models\DisponibilidadProfesional;
use Carbon\Carbon;

class ReservaWidget extends Component
{
    public $profesional_id = '';
    public $especialidad_id = '';
    public $servicio_id = '';
    public $consultorio_id = '';
    public $fecha = '';
    public $hora = '';

    public function updatedProfesionalId()
    {
        
        $this->reset(['especialidad_id', 'servicio_id']);
    }

    public function updatedEspecialidadId()
    {
        
        $this->reset(['servicio_id']);
    }

    public function submit()
    {
        $this->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'especialidad_id'=> 'required|exists:especialidades,id',
            'servicio_id'    => 'required|exists:servicios,id',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora'           => 'required|date_format:H:i',
            'consultorio_id' => 'nullable|exists:consultorios,id',
        ]);

        
        $servicio = Servicio::where('id', $this->servicio_id)
                    ->where('especialidad_id', $this->especialidad_id)
                    ->firstOrFail(); 

        $inicio = Carbon::createFromFormat('Y-m-d H:i', "{$this->fecha} {$this->hora}");
        $fin    = (clone $inicio)->addMinutes((int)$servicio->duracion_estimada); 

        
        $diaSemana = $inicio->locale('es')->dayName; 
        $diaSemanaCapitalizado = ucfirst($diaSemana); 

        $dispOk = DisponibilidadProfesional::where('profesional_id', $this->profesional_id) 
            ->where('dia_semana', $diaSemanaCapitalizado)
            ->where('hora_inicio', '<=', $inicio->format('H:i:s'))
            ->where('hora_fin', '>=', $fin->format('H:i:s'))
            ->exists();

        if (!$dispOk) {
            $this->addError('hora', 'El profesional no tiene disponibilidad para ese día/horario.');
            return;
        }

        
        $solapa = Turno::where('profesional_id', $this->profesional_id)         
            ->where('fecha_turno', $inicio->toDateString())
            ->where(function($q) use ($inicio, $fin) {
                $q->where(function($q2) use ($inicio, $fin) {
                    
                    $q2->where('hora_inicio_turno', '<', $fin->format('H:i:s'))
                       ->where('hora_fin_turno', '>', $inicio->format('H:i:s'));
                });
            })
            ->exists();

        if ($solapa) {
            $this->addError('hora', 'Ya existe un turno asignado que se superpone en ese horario.');
            return;
        }

        
        Turno::create([
            'paciente_id'       => Auth::id(),               
            'profesional_id'    => $this->profesional_id,    
            'servicio_id'       => $this->servicio_id,       
            'consultorio_id'    => $this->consultorio_id ?: null, 
            'fecha_turno'       => $inicio->toDateString(),
            'hora_inicio_turno' => $inicio->format('H:i:s'),
            'hora_fin_turno'    => $fin->format('H:i:s'),
            'estado_turno'      => 'Pendiente',              
        ]);

        $this->reset(['especialidad_id','servicio_id','consultorio_id','fecha','hora']);
        $this->dispatch('toast', type: 'success', message: '¡Turno registrado correctamente!');
    }

    public function render()
    {
        
        $profesionales = Profesional::with('user')->orderBy('id')->get(); 
        
        $especialidades = collect();
        if ($this->profesional_id) {
            $especialidades = Profesional::with('especialidades')
                ->find($this->profesional_id)?->especialidades()->orderBy('nombre_especialidad')->get() ?? collect();
        }

       
        $servicios = collect();
        if ($this->especialidad_id) {
            $servicios = Servicio::where('especialidad_id', $this->especialidad_id)->orderBy('nombre_servicio')->get();
        }

        
        $consultorios = Consultorio::orderBy('nombre_consultorio')->get(); 

        return view('livewire.dashboard.reserva-widget', compact(
            'profesionales','especialidades','servicios','consultorios'
        ));
    }
}
