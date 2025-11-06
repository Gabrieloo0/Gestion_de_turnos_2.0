<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard · Pacientes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 🔹 Listado de Pacientes embebido dentro del Dashboard --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <livewire:pacientes.index />
            </div>
        </div>
    </div>
</x-app-layout>
