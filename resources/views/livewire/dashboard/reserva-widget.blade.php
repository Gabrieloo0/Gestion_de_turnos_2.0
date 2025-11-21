<div class="w-full max-w-4xl mx-auto animate-fade-slide">
  <div class="flex items-center justify-center gap-8 mb-8">
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold"> 1 </div>
        <span class="text-primary font-semibold">PASO</span>
    </div>
    <div class="text-gray-400 text-3xl">······</div>
    <div class="flex items-center gap-2 opacity-50">
      <div class="w-8 h-8 rounded-full border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold"> 2 </div>
      <span class="text-gray-400 font-semibold">PASO</span>
    </div>
  </div>

  <h1 class="text-center font-title text-2xl font-bold text-primaryDark mb-10">
    Solicitar un Turno para Kinesiología
  </h1>

  <div class="bg-[#f5fffc] border border-primary/20 shadow-lg rounded-2xl p-10">
    <div class="mb-6">
      <label class="block text-gray-700 font-semibold mb-1">Elige la especialidad:</label>
      <select wire:model="especialidad_id"
        class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary">
        <option value="">Seleccionar</option>
        @foreach($especialidades as $e)
        <option value="{{ $e->id }}">{{ $e->nombre_especialidad }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-6">
      <label class="block text-gray-700 font-semibold mb-2">Elige al profesional:</label>
      
      <div class="flex gap-3 flex-wrap">
        @foreach($profesionales as $p)
        <button type="button"
          wire:click="$set('profesional_id', {{ $p->id }})"
          class="px-4 py-2 rounded-xl border
            {{ $profesional_id == $p->id 
            ? 'bg-primary text-white border-primary' 
            : 'border-primary text-primary bg-white' }}">
            {{ $p->user->name }} {{ $p->user->last_name }}
        </button>
        @endforeach
      </div>

      @if($especialidad_id && $profesional_id)
      <p class="mt-2 text-gray-600 text-sm">
        Seleccionaste la <strong>[{{ $especialidadSeleccionada }}]</strong>
        [Profesional <strong>“{{ $profesionalSeleccionado }}”</strong>]
      </p>
      @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Servicio o Motivo:</label>
        <select wire:model="servicio_id"
          class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary">
          <option value="">Seleccionar</option>
          @foreach($servicios as $s)
            <option value="{{ $s->id }}">{{ $s->nombre_servicio }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Sesiones:</label>
        <input type="number" min="1" wire:model="sesiones"
          class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary"
          placeholder="Cantidad">
        </input>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Fecha:</label>
        <div class="relative">
          <input type="date" wire:model="fecha"
          class="w-full border-gray-300 rounded-xl py-3 px-4 pl-10 focus:ring-primary focus:border-primary">
        </div>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Horario:</label>
        <div class="flex flex-wrap gap-2">
          @foreach($horarios as $horaItem)
          <button type="button"
           wire:click="$set('hora', '{{ $horaItem }}')"
           class="px-3 py-1.5 rounded-lg border text-sm
           {{ $hora == $horaItem 
           ? 'bg-primary text-white border-primary'
           : 'border-gray-300 text-gray-600 bg-white' }}">
           {{ $horaItem }}
          </button>
          @endforeach
        </div>
      </div>
    </div>

    <div class="mb-8">
      <label class="block text-gray-700 font-semibold mb-1">Consultorio:</label>
      <select wire:model="consultorio_id"
        class="w-full border-gray-300 rounded-xl py-3 px-4 focus:ring-primary focus:border-primary">
        <option value="">Seleccionar</option>
        @foreach($consultorios as $c)
          <option value="{{ $c->id }}">{{ $c->nombre_consultorio }}</option>
        @endforeach
      </select>
    </div>

    <button type="button"
      class="w-full bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primaryDark transition">
      Pedir un Turno
    </button>
  </div>
</div>