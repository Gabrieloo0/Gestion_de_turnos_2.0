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
        $this->reset(['servicio_id','profesional_id','hora','horarios']);
    }

    public function updatedFecha()
    {
        $this->generarHorarios();
    }

    public function updatedProfesional_id()
    {
        $this->reset(['hora','horarios']);
        $this->generarHorarios();
    }

    public function updatedServicio_id()
    {
        $this->horarios = [];

        if (!$this->servicio_id) return;

        $servicio = Servicio::find($this->servicio_id);

        if ($servicio) {
            $this->horarios = \App\Livewire\Dashboard\Horarios::generar($servicio->duracion_estimada);
        }
    }

    public function generarHorarios()
    {
        $this->horarios = [];

        if (!$this->profesional_id || !$this->fecha) return;

        $dia = ucfirst(Carbon::parse($this->fecha)->locale('es')->dayName);

        $disponibilidades = DisponibilidadProfesional::where('profesional_id', $this->profesional_id)
            ->where('dia_semana', $dia)
            ->get();

        foreach ($disponibilidades as $disp) {
            $inicio = Carbon::parse($disp->hora_inicio);
            $fin = Carbon::parse($disp->hora_fin);

            while ($inicio < $fin) {
                $this->horarios[] = $inicio->format('H:i');
                $inicio->addMinutes(30);
            }
        }
    }

    public function guardarturno()
    {
        $this->validate([
            'profesional_id' => 'required|exists:profesionales,id',
            'especialidad_id'=> 'required|exists:especialidades,id',
            'servicio_id'    => 'required|exists:servicios,id',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora'           => 'required',
            'consultorio_id' => 'nullable|exists:consultorios,id',
            'sesiones'       => 'required|integer|min:1|max:20',
        ]);

        $servicio = Servicio::findOrFail($this->servicio_id);

        $turnosGenerados = 0;

        for ($i = 0; $i < $this->sesiones; $i++) {

            $fechaActual = Carbon::parse($this->fecha)->addDays($i);

            while ($fechaActual->isWeekend()) {
                $fechaActual->addDay();
            }

            $inicio = Carbon::parse("{$fechaActual->format('Y-m-d')} {$this->hora}:00");
            $fin = (clone $inicio)->addMinutes($servicio->duracion_estimada);

            $solapa = Turno::where('profesional_id', $this->profesional_id)
                ->where('fecha_turno', $fechaActual->toDateString())
                ->where(function($q) use ($inicio, $fin) {
                    $q->whereBetween('hora_inicio_turno', [$inicio->format('H:i:s'), $fin->format('H:i:s')])
                      ->orWhereBetween('hora_fin_turno', [$inicio->format('H:i:s'), $fin->format('H:i:s')])
                      ->orWhere(function($q2) use ($inicio, $fin) {
                          $q2->where('hora_inicio_turno', '<=', $inicio->format('H:i:s'))
                             ->where('hora_fin_turno', '>=', $fin->format('H:i:s'));
                      });
                })
                ->exists();

            if ($solapa) {
                $this->dispatch('toast', type:'error',
                    message:"El horario {$inicio->format('H:i')} ya está ocupado");
                return;
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

        if ($turnosGenerados > 0) {
            $this->dispatch('toast', type:'success',
                message:"Se generaron {$turnosGenerados} turnos correctamente");
        }

        $this->reset([
            'especialidad_id','servicio_id','consultorio_id',
            'fecha','hora','sesiones'
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.reserva-widget', [
            'especialidades' => Especialidad::orderBy('nombre_especialidad')->get(),
            'profesionales'  => $this->especialidad_id
                ? Profesional::whereHas('especialidades', function($q){
                        $q->where('especialidad_id',$this->especialidad_id);
                    })->with('user')->get()
                : collect(),
            'servicios'      => $this->especialidad_id
                ? Servicio::where('especialidad_id',$this->especialidad_id)->get()
                : collect(),
            'consultorios'   => Consultorio::orderBy('nombre_consultorio')->get(),
            'horarios'       => $this->horarios
        ]);
    }
}
