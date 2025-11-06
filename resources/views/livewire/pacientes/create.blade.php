<div class="max-w-2xl mx-auto space-y-6">
    <h1 class="text-2xl font-semibold">Nuevo paciente</h1>

    @if (session('ok'))
      <div class="p-3 rounded-xl bg-green-100 text-green-800">{{ session('ok') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm">Nombre</label>
                <input type="text" wire:model.defer="name" class="w-full border rounded-xl px-3 py-2">
                @error('name') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm">Apellido</label>
                <input type="text" wire:model.defer="last_name" class="w-full border rounded-xl px-3 py-2">
                @error('last_name') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="text-sm">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border rounded-xl px-3 py-2">
                @error('email') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm">Teléfono</label>
                <input type="text" wire:model.defer="phone" class="w-full border rounded-xl px-3 py-2">
                @error('phone') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm">Fecha de nacimiento</label>
                <input type="date" wire:model.defer="birthdate" class="w-full border rounded-xl px-3 py-2">
                @error('birthdate') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-2 justify-end">
            <a href="{{ route('pacientes.index') }}" class="px-4 py-2 rounded-xl border">Cancelar</a>
            <button wire:click="save" class="px-4 py-2 rounded-xl bg-blue-600 text-white">Guardar</button>
        </div>
    </div>
</div>
