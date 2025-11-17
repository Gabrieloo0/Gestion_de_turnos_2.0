<div class="w-full max-w-xl mx-auto">
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 pt-6">
      <h2 class="text-xl font-semibold">Turnos</h2>
      <p class="text-sm text-gray-500">Elegí el profesional y completá los datos.</p>
    </div>

    <div class="mt-4 bg-pink-500 px-6 py-6">
      <form wire:submit.prevent="submit" class="space-y-4">

        <!-- Profesional (primero) -->
        <div>
          <label class="text-white text-sm mb-1 block">Profesional</label>
          <select wire:model="profesional_id"
                  class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200">
            <option value="">Seleccionar…</option>
            @foreach($profesionales as $p)
              <option value="{{ $p->id }}">
                {{ $p->user->name }} {{ $p->user->last_name }}
              </option>
            @endforeach
          </select>
          @error('profesional_id') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Especialidad (del profesional) -->
        <div>
          <label class="text-white text-sm mb-1 block">Especialidad</label>
          <select wire:model="especialidad_id"
                  class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200"
                  @disabled(!$profesional_id)>
            <option value="">Seleccionar…</option>
            @foreach($especialidades as $e)
              <option value="{{ $e->id }}">{{ $e->nombre_especialidad }}</option>
            @endforeach
          </select>
          @error('especialidad_id') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Servicio (según especialidad) -->
        <div>
          <label class="text-white text-sm mb-1 block">Servicio</label>
          <select wire:model="servicio_id"
                  class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200"
                  @disabled(!$especialidad_id)>
            <option value="">Seleccionar…</option>
            @foreach($servicios as $s)
              <option value="{{ $s->id }}">{{ $s->nombre_servicio }}</option>
            @endforeach
          </select>
          @error('servicio_id') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Fecha y hora -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="text-white text-sm mb-1 block">Fecha</label>
            <input type="date" wire:model="fecha"
                   class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200" />
            @error('fecha') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label class="text-white text-sm mb-1 block">Hora</label>
            <input type="time" wire:model="hora"
                   class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200" />
            @error('hora') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        <!-- Consultorio (opcional) -->
        <div>
          <label class="text-white text-sm mb-1 block">Consultorio (opcional)</label>
          <select wire:model="consultorio_id"
                  class="w-full rounded-lg border-0 focus:ring-2 focus:ring-pink-200">
            <option value="">Sin asignar</option>
            @foreach($consultorios as $c)
              <option value="{{ $c->id }}">{{ $c->nombre_consultorio }}</option>
            @endforeach
          </select>
          @error('consultorio_id') <p class="text-white/90 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
          <button type="submit"
                  class="w-full bg-white text-pink-600 font-semibold py-2.5 rounded-lg hover:bg-pink-50">
            Agregar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
