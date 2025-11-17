<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Pacientes</h1>
        <div class="flex items-center gap-2">
            <input type="text"
                   wire:model.live.debounce.300ms="q"
                   placeholder="Buscar apellido, nombre, email, teléfono…"
                   class="border rounded-xl px-3 py-2 w-72">
            <select wire:model.live="perPage" class="border rounded-xl px-3 py-2">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
            <a href="{{ route('pacientes.create') }}"
               class="px-4 py-2 rounded-xl bg-blue-600 text-white">
                Nuevo
            </a>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="px-4 py-2">Apellido y Nombre</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Teléfono</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $u)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $u->last_name }}, {{ $u->name }}</td>
                    <td class="px-4 py-2">{{ $u->email }}</td>
                    <td class="px-4 py-2">{{ $u->phone }}</td>
                    <td class="px-4 py-2">
                        @if (Route::has('pacientes.edit'))
                            <a href="{{ route('pacientes.edit', $u->id) }}"
                               class="text-blue-600 underline">Editar</a>
                        @else
                            <span class="text-gray-400">Sin edición</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Sin resultados
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $items->links() }}</div>
</div>
