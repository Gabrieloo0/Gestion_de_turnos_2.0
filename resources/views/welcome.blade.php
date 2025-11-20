<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-title text-xl text-gray-800 leading-tight">
            Bienvenido! Reserva tu turno
        </h2> --}}
    </x-slot>

    <div class="py-6">
        {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4"> --}}
        @livewire('dashboard.reserva-widget')
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                <livewire:pacientes.index />
            </div> --}}
    </div>
</x-app-layout>