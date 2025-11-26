<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        $this->reset(['profesional_id','servicio_id','hora','horarios']);
    }

    public function updatedProfesional_id()
    {
        $this->reset(['hora','horarios']);
        $this->generarHorarios();
    }

    public function updatedFecha()
    {
        $this->generarHorarios();
    }

    public function updatedServicio_id()
    {
        $this->horarios = [];

        if (!$this->servicio_id) return;

        $servicio = Servicio::find($this->servicio_id);

        if ($servicio) {
            $this->horarios = \App\Livewire\Dashboard\Horarios::generar(
                $servicio->duracion_estimada
            );
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
            $fin    = Carbon::parse($disp->hora_fin);

            while ($inicio < $fin) {
                $this->horarios[] = $inicio->format('H:i');
                $inicio->addMinutes(30);
            }
        }
    }

    public function guardarturno()
    {
        $this->resetErrorBag();

        $data = [
            'profesional_id'  => $this->profesional_id,
            'especialidad_id' => $this->especialidad_id,
            'servicio_id'     => $this->servicio_id,
            'fecha'           => $this->fecha,
            'hora'            => $this->hora,
            'consultorio_id'  => $this->consultorio_id,
            'sesiones'        => $this->sesiones,
        ];

        $validator = Validator::make(
            $data,
            [
                'profesional_id'  => 'required|exists:profesionales,id',
                'especialidad_id' => 'required|exists:especialidades,id',
                'servicio_id'     => 'required|exists:servicios,id',
                'fecha'           => 'required|date|after_or_equal:today',
                'hora'            => 'required',
                'consultorio_id'  => 'required|exists:consultorios,id',
                'sesiones'        => 'required|integer|min:1|max:20',
            ],
            [
                'profesional_id.required'  => 'Debes seleccionar un profesional.',
                'especialidad_id.required' => 'Debes seleccionar una especialidad.',
                'servicio_id.required'     => 'Debes seleccionar un servicio.',
                'fecha.required'           => 'Debes seleccionar una fecha.',
                'fecha.after_or_equal'     => 'La fecha no puede ser anterior a hoy.',
                'hora.required'            => 'Debes seleccionar un horario.',
                'consultorio_id.required'  => 'Debes seleccionar un consultorio.',
                'sesiones.required'        => 'Debes ingresar la cantidad de sesiones.',
                'sesiones.min'             => 'La cantidad mínima de sesiones es 1.',
                'sesiones.max'             => 'La cantidad máxima de sesiones es 20.',
            ]
        );

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());

            $this->dispatch(
                'toast',
                type:'error',
                message: $validator->errors()->first()
            );

            return;
        }

        $ahora = Carbon::now();
        $fechaSeleccionada = Carbon::parse($this->fecha);

        if ($fechaSeleccionada->isToday()) {

            $fechaHoraTurno = Carbon::parse($this->fecha . ' ' . $this->hora);

            if ($fechaHoraTurno->lessThanOrEqualTo($ahora)) {
                $this->dispatch(
                    'toast',
                    type: 'error',
                    message: 'El horario seleccionado ya pasó. Elegí un horario futuro.'
                );
                return;
            }
        }

        $servicio = Servicio::findOrFail($this->servicio_id);

        for ($i = 0; $i < $this->sesiones; $i++) {

            $fechaActual = Carbon::parse($this->fecha)->addDays($i);

            while ($fechaActual->isWeekend()) {
                $fechaActual->addDay();
            }

            $inicio = Carbon::parse($fechaActual->format('Y-m-d') . " {$this->hora}:00");
            $fin = (clone $inicio)->addMinutes($servicio->duracion_estimada);

            $ocupado = Turno::where('profesional_id', $this->profesional_id)
                ->where('consultorio_id', $this->consultorio_id)
                ->where('fecha_turno', $fechaActual->toDateString())
                ->where('hora_inicio_turno', $inicio->format('H:i:s'))
                ->exists();

            if ($ocupado) {
                $this->dispatch(
                    'toast',
                    type:'error',
                    message:"Ya existe un turno el {$inicio->format('d/m')} a las {$inicio->format('H:i')}."
                );
                return;
            }
        }

        $turnosGenerados = 0;
        $this->resumenTurnos = [];

        for ($i = 0; $i < $this->sesiones; $i++) {

            $fechaActual = Carbon::parse($this->fecha)->addDays($i);

            while ($fechaActual->isWeekend()) {
                $fechaActual->addDay();
            }

            $inicio = Carbon::parse($fechaActual->format('Y-m-d') . " {$this->hora}:00");
            $fin = (clone $inicio)->addMinutes($servicio->duracion_estimada);

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
                'hora'  => $inicio->format('H:i'),
            ];

            $turnosGenerados++;
        }

        $this->dispatch(
            'toast',
            type:'success',
            message:"Se generaron {$turnosGenerados} turnos correctamente."
        );

        $this->reset([
            'especialidad_id',
            'profesional_id',
            'servicio_id',
            'consultorio_id',
            'fecha',
            'hora',
            'sesiones',
            'horarios',
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.reserva-widget', [
            'especialidades' => Especialidad::orderBy('nombre_especialidad')->get(),
            'profesionales'  => $this->especialidad_id
                ? Profesional::whereHas('especialidades', fn($q) =>
                        $q->where('especialidad_id', $this->especialidad_id)
                    )->with('user')->get()
                : collect(),
            'servicios'      => $this->especialidad_id
                ? Servicio::where('especialidad_id',$this->especialidad_id)->get()
                : collect(),
            'consultorios'   => Consultorio::orderBy('nombre_consultorio')->get(),
            'horarios'       => $this->horarios,
        ]);
    }
}
