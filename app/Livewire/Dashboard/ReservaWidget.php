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
    public $sesiones = 1;
    public $profesional_id = '';
    public $especialidad_id = '';
    public $servicio_id = '';
    public $consultorio_id = '';
    public $fecha = '';
    public $hora = '';
    public $horarios = [];
    public $resumenTurnos = [];

    public function updatedEspecialidad_id()
    {
        $this->reset(['servicio_id', 'profesional_id', 'hora']);
    }

    public function updatedFecha()
    {
        $this->generarHorarios();
    }

    public function updatedProfesional_id()
    {
        $this->reset(['servicio_id', 'hora']);
        $this->generarHorarios();
    }

    public function generarHorarios()
    {
        $this->horarios = [];

        if (!$this->profesional_id || !$this->fecha) {
            return;
        }

        $dia = Carbon::parse($this->fecha)->locale('es')->dayName;
        $dia = ucfirst($dia);

        $disp = DisponibilidadProfesional::where('profesional_id', $this->profesional_id)
            ->where('dia_semana', $dia)
            ->first();

        if (!$disp) {
            return;
        }

        $inicio = Carbon::parse($disp->hora_inicio);
        $fin    = Carbon::parse($disp->hora_fin);

        while ($inicio < $fin) {
            $this->horarios[] = $inicio->format('H:i');
            $inicio->addMinutes(30);
        }
    }

    public function guardarturno()
    {
        $this->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'especialidad_id'=> 'required|exists:especialidades,id',
            'servicio_id'    => 'required|exists:servicios,id',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora'           => 'required|date_format:H:i',
            'consultorio_id' => 'nullable|exists:consultorios,id',
            'sesiones'       => 'required|integer|min:1|max:20',
        ]);

        $servicio = Servicio::where('id', $this->servicio_id)
            ->where('especialidad_id', $this->especialidad_id)
            ->firstOrFail();

        $inicio = Carbon::createFromFormat('Y-m-d H:i', "{$this->fecha} {$this->hora}");
        $duracion = (int)$servicio->duracion_estimada;
        $fin = (clone $inicio)->addMinutes($duracion);

        $turnosGenerados = 0;

        for ($i = 0; $i < $this->sesiones; $i++) {

            $fechaActual = Carbon::parse($this->fecha)->addDays($i);

            while ($fechaActual->isWeekend()) {
                $fechaActual->addDay();
            }

            $diaSemana = ucfirst($fechaActual->locale('es')->dayName);

            $dispOk = DisponibilidadProfesional::where('profesional_id', $this->profesional_id)
                ->where('dia_semana', $diaSemana)
                ->where('hora_inicio', '<=', $inicio->format('H:i:s'))
                ->where('hora_fin', '>=', $fin->format('H:i:s'))
                ->exists();

            if (!$dispOk) {
                continue; 
            }

            $solapa = Turno::where('profesional_id', $this->profesional_id)
                ->where('fecha_turno', $fechaActual->toDateString())
                ->where(function($q) use ($inicio, $fin) {
                    $q->where('hora_inicio_turno', '<', $fin->format('H:i:s'))
                      ->where('hora_fin_turno', '>', $inicio->format('H:i:s'));
                })
                ->exists();

            if ($solapa) {
                continue; 
            }

            Turno::create([
                'paciente_id'       => Auth::id(),
                'profesional_id'    => $this->profesional_id,
                'servicio_id'       => $this->servicio_id,
                'consultorio_id'    => $this->consultorio_id,
                'fecha_turno'       => $fechaActual->toDateString(),
                'hora_inicio_turno' => $inicio->format('H:i:s'),
                'hora_fin_turno'    => $fin->format('H:i:s'),
                'estado_turno'      => 'Pendiente',
            ]);

            $this->resumenTurnos[] = [
                'fecha' => $fechaActual->format('d/m/Y'),
                'hora'  => $inicio->format('H:i')
            ];

            $turnosGenerados++;
        }

        $this->reset(['especialidad_id','servicio_id','consultorio_id','fecha','hora','sesiones']);

        if ($turnosGenerados > 0) {
            $this->dispatch('toast', type: 'success',
                message: "¡Se generaron {$turnosGenerados} turnos correctamente!");
        } else {
            $this->dispatch('toast', type: 'error',
                message: "No se pudo generar ningún turno. Verificá disponibilidad.");
        }
    }

    public function render()
    {
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();
        
        $especialidadSeleccionada = null;
        if ($this->especialidad_id) {
            $especialidadSeleccionada = Especialidad::find($this->especialidad_id)?->nombre_especialidad;
        }

        $profesionalSeleccionado = null;
        if ($this->profesional_id) {
            $profesionalSeleccionado = Profesional::find($this->profesional_id)?->user?->name;
        }

        $profesionales = collect();
        if ($this->especialidad_id) {
            $profesionales = Profesional::whereHas('especialidades', function($q) {
                $q->where('especialidad_id', $this->especialidad_id);
            })
            ->with('user')
            ->orderBy('id')
            ->get();
        }
        
        $servicios = collect();
        if ($this->especialidad_id) {
            $servicios = Servicio::where('especialidad_id', $this->especialidad_id)
                ->orderBy('nombre_servicio')
                ->get();
        }

        $consultorios = Consultorio::orderBy('nombre_consultorio')->get();

        $horarios = $this->horarios;

        return view('livewire.dashboard.reserva-widget', compact(
            'especialidades', 'profesionales', 'servicios', 'consultorios', 'horarios', 'especialidadSeleccionada', 'profesionalSeleccionado'
        ));
    }
}