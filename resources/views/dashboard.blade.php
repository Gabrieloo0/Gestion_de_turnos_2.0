<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Gestión
            </h2>
            <p class="text-sm text-gray-500">
                Seleccioná un módulo desde el menú lateral para administrar la clínica.
            </p>
        </div>
    </x-slot>

    @php
        $totalPacientes = \App\Models\User::pacientes()->count();
        $totalProfesionales = \App\Models\Profesional::count();
        $totalTurnos = \App\Models\Turno::count();
        $totalUsuarios = \App\Models\User::count();

        $today = \Illuminate\Support\Carbon::today();
        $todayTurnos = \App\Models\Turno::with(['paciente', 'profesional.user'])
            ->whereDate('fecha_turno', $today)
            ->orderBy('hora_inicio_turno')
            ->get();

        $nextTurnos = \App\Models\Turno::with(['paciente', 'profesional.user'])
            ->whereDate('fecha_turno', '>', $today)
            ->orderBy('fecha_turno')
            ->orderBy('hora_inicio_turno')
            ->limit(5)
            ->get();

        $weekWindow = collect(range(6, 0))->map(function ($daysAgo) use ($today) {
            $date = (clone $today)->subDays($daysAgo);
            return [
                'label' => $date->isoFormat('DD/MM'),
                'count' => \App\Models\Turno::whereDate('fecha_turno', $date)->count(),
            ];
        });

        $maxWeekValue = max($weekWindow->pluck('count')->max(), 1);
    @endphp

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-indigo-900/10 backdrop-blur">
            <p class="text-xs uppercase tracking-[0.3em] text-indigo-200/80">Pacientes</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $totalPacientes }}</p>
            <p class="mt-1 text-xs text-indigo-200/60">Pacientes activos registrados</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-indigo-900/10 backdrop-blur">
            <p class="text-xs uppercase tracking-[0.3em] text-purple-200/80">Profesionales</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $totalProfesionales }}</p>
            <p class="mt-1 text-xs text-purple-200/60">Equipo interdisciplinario</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-indigo-900/10 backdrop-blur">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-200/80">Turnos</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $totalTurnos }}</p>
            <p class="mt-1 text-xs text-slate-200/60">Agenda consolidada</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-indigo-900/10 backdrop-blur">
            <p class="text-xs uppercase tracking-[0.3em] text-blue-200/80">Usuarios</p>
            <p class="mt-3 text-4xl font-semibold text-white">{{ $totalUsuarios }}</p>
            <p class="mt-1 text-xs text-blue-200/60">Pacientes + staff</p>
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-indigo-950/20 backdrop-blur lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-200/80">Turnos del día</p>
                    <h3 class="mt-2 text-xl font-semibold text-white">Agenda de hoy</h3>
                    <p class="text-xs text-slate-300/70">{{ $todayTurnos->count() }} turnos programados</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-500/20 text-indigo-200">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </span>
            </div>

            <div class="mt-5 space-y-3">
                @forelse ($todayTurnos as $turno)
                    <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-white/[0.04] px-4 py-3 text-sm text-slate-200">
                        <div>
                            <p class="font-semibold">{{ $turno->paciente?->name ?? 'Paciente sin asignar' }}</p>
                            <p class="text-xs text-slate-400">
                                {{ $turno->profesional?->user?->name ?? 'Profesional sin asignar' }}
                                · {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($turno->hora_inicio_turno, 0, 5)) }} hs
                            </p>
                        </div>
                        <span class="rounded-xl border border-indigo-400/40 bg-indigo-500/10 px-3 py-1 text-xs text-indigo-200">
                            {{ ucfirst($turno->estado_turno ?? 'Pendiente') }}
                        </span>
                    </div>
                @empty
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-5 text-center text-sm text-slate-300">
                        No hay turnos programados para hoy.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-indigo-950/20 backdrop-blur">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-purple-200/80">Próximos turnos</p>
                    <h3 class="mt-2 text-xl font-semibold text-white">Agenda próxima</h3>
                    <p class="text-xs text-slate-300/70">{{ $nextTurnos->count() }} turnos próximos</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-500/20 text-purple-200">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                    </svg>
                </span>
            </div>

            <div class="mt-5 space-y-4">
                @forelse ($nextTurnos as $turno)
                    <div class="rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-slate-200">
                        <p class="font-semibold">{{ \Illuminate\Support\Carbon::parse($turno->fecha_turno)->isoFormat('dddd D MMM') }}</p>
                        <p class="text-xs text-slate-400">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($turno->hora_inicio_turno, 0, 5)) }} ·
                            {{ $turno->paciente?->name ?? 'Sin paciente' }}
                        </p>
                        <p class="mt-1 text-xs text-indigo-200/70">
                            {{ $turno->profesional?->user?->name ?? 'Profesional sin asignar' }}
                        </p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-5 text-center text-sm text-slate-300">
                        Todavía no se registraron próximos turnos.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-indigo-950/20 backdrop-blur lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-sky-200/80">Pacientes</p>
                    <h3 class="mt-2 text-xl font-semibold text-white">Distribución semanal</h3>
                    <p class="text-xs text-slate-300/70">Turnos asignados últimos 7 días</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-500/20 text-sky-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3v18h18M7.5 15l3-3 2.25 2.25L18 9"/>
                    </svg>
                </span>
            </div>

            <div class="mt-6 grid grid-cols-7 gap-3">
                @foreach ($weekWindow as $day)
                    @php
                        $percentage = $day['count'] > 0 ? ($day['count'] / $maxWeekValue) * 100 : 6;
                    @endphp
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-40 w-12 items-end rounded-2xl border border-white/10 bg-white/5 p-1">
                            <div class="w-full rounded-xl bg-gradient-to-t from-indigo-500/80 via-purple-500/70 to-sky-400/80"
                                 style="height: {{ max($percentage, 8) }}%"></div>
                        </div>
                        <p class="text-xs text-slate-300/70">{{ $day['label'] }}</p>
                        <span class="rounded-full border border-white/10 bg-white/5 px-2 py-0.5 text-[11px] text-indigo-200">
                            {{ $day['count'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-indigo-950/20 backdrop-blur">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-violet-200/80">Reservar</p>
                    <h3 class="mt-2 text-xl font-semibold text-white">Turno express</h3>
                    <p class="text-xs text-slate-300/70">Agendá rápidamente desde aquí</p>
                </div>
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-violet-500/20 text-violet-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v12m6-6H6"/>
                    </svg>
                </span>
            </div>

            <div class="mt-6">
                @livewire('dashboard.reserva-widget')
            </div>
        </div>
    </section>

    @include('dashboard.readme-panel')
</x-admin-layout>
