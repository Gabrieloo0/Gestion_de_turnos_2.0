<div class="w-full max-w-5xl mx-auto animate-fade-slide">

    {{-- Indicador de Pasos --}}
    <div class="flex items-center justify-center gap-8 mb-8">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">1</div>
            <span class="text-primary font-semibold">PASO</span>
        </div>

        <div class="h-0.5 w-16 bg-gray-400"></div>

        <div class="flex items-center gap-2 opacity-50">
            <div class="w-8 h-8 rounded-full border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold">2</div>
            <span class="text-gray-400 font-semibold">PASO</span>
        </div>
    </div>

    <h1 class="text-center font-title text-2xl font-bold text-primaryDark mb-10">
        Solicitar un Turno para Kinesiología
    </h1>

    {{-- Caja contenedora principal --}}
    <div class="bg-white border border-gray-200 shadow-xl rounded-2xl p-8 sm:p-10">

        {{-- Especialidad --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Elige la especialidad:</label>

            <select 
                wire:model.live="especialidad_id"
                class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
            >
                <option value="">Seleccionar</option>
                @foreach($especialidades as $e)
                    <option value="{{ $e->id }}">{{ $e->nombre_especialidad }}</option>
                @endforeach
            </select>
        </div>

        {{-- Profesional --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Elige al profesional:</label>

            <select
                wire:model="profesional_id"
                class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
                @if($profesionales->isEmpty()) disabled @endif
            >
                <option value="">Seleccionar</option>

                @foreach($profesionales as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->user->name ?? 'Nombre Desconocido' }} {{ $p->user->last_name ?? '' }}
                    </option>
                @endforeach
            </select>

            {{-- Resumen --}}
            @if($especialidad_id && $profesional_id)
                <p class="mt-2 text-gray-600 text-sm">
                    Seleccionaste la <strong>[{{ $especialidadSeleccionada }}]</strong> —
                    Profesional <strong>“{{ $profesionalSeleccionado }}”</strong>
                </p>
            @endif
        </div>

        {{-- Servicio - Sesiones --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Servicio o Motivo:</label>

                <select 
                    wire:model="servicio_id"
                    class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
                >
                    <option value="">Seleccionar</option>
                    @foreach($servicios as $s)
                        <option value="{{ $s->id }}">{{ $s->nombre_servicio }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Sesiones:</label>

                <input 
                    type="number" 
                    min="1" 
                    wire:model="sesiones"
                    class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
                    placeholder="Cantidad"
                >
            </div>
        </div>

        {{-- Fecha y horario --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Fecha:</label>

                <input 
                    type="date" 
                    wire:model.live="fecha"
                    class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Horario:</label>

                <div class="flex flex-wrap gap-2">
                    @foreach($horarios as $horaItem)
                        <button 
                            type="button"
                            wire:click="$set('hora', '{{ $horaItem }}')"
                            class="px-3 py-1.5 rounded-lg border text-sm 
                                {{ $hora == $horaItem 
                                    ? 'bg-primary text-white border-primary' 
                                    : 'border-gray-300 text-gray-600 bg-white' 
                                }}"
                        >
                            {{ $horaItem }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Consultorio --}}
        <div class="mb-8">
            <label class="block text-gray-700 font-semibold mb-2">Consultorio:</label>

            <select 
                wire:model="consultorio_id"
                class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
            >
                <option value="">Seleccionar</option>
                @foreach($consultorios as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre_consultorio }}</option>
                @endforeach
            </select>

            @error('consultorio_id') 
                <span class="text-danger text-sm">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Botón --}}
        <button 
            type="button"
            wire:click="guardarturno"
            class="w-full bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primaryDark transition"
        >
            Pedir un Turno
        </button>

        {{-- Resumen de turnos --}}
        @if(count($resumenTurnos) > 0)
            <div class="mt-4 p-4 bg-primary/10 border border-primary rounded-xl text-primaryDark">
                <h3 class="font-semibold mb-2">Resumen de turnos generados:</h3>

                <ul class="list-disc ml-4">
                    @foreach($resumenTurnos as $t)
                        <li>{{ $t['fecha'] }} — {{ $t['hora'] }} hs</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

</div>
