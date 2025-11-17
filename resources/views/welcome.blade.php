<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenido! Reserva tu turno
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔹 Listado de Pacientes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                <livewire:pacientes.index />
            </div>

            {{-- 🔹 Reserva de Turnos (formulario rosa/blanco) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                @livewire('dashboard.reserva-widget')
                {{-- también podés usar: <livewire:dashboard.reserva-widget /> --}}
            </div>

        </div>
    </div>
</x-app-layout>
