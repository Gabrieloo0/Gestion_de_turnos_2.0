@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 font-sans antialiased text-slate-100">
        @php
            $user = auth()->user();
            $isEmployee = $user?->hasRole('Super Admin', 'Profesional') ?? false;
            $isSuperAdmin = $user?->hasRole('Super Admin') ?? false;
            $doctorName = $user?->name ? \Illuminate\Support\Str::of($user->name)->headline() : 'Profesional';
            $especialidades = $user?->profesional?->especialidades?->pluck('nombre_especialidad')->filter()->implode(', ');
            $especialidadTexto = $especialidades ?: 'Especialidad no asignada';
            $turnoHoy = now()->locale('es')->translatedFormat('l j \\d\\e F');

            $navItems = collect([
                [
                    'key' => 'dashboard',
                    'title' => 'Turnos',
                    'label' => 'Gestión de turnos',
                    'route' => route('dashboard'),
                    'active' => request()->routeIs('dashboard'),
                    'show' => $isEmployee,
                ],
                [
                    'key' => 'pacientes',
                    'title' => 'Pacientes',
                    'label' => 'Gestión de pacientes',
                    'route' => route('pacientes.index'),
                    'active' => request()->routeIs('pacientes.*'),
                    'show' => $isEmployee,
                ],
                [
                    'key' => 'personal',
                    'title' => 'Personal',
                    'label' => 'Gestión de profesionales',
                    'route' => route('empleados.create'),
                    'active' => request()->routeIs('empleados.*'),
                    'show' => $isSuperAdmin,
                ],
                [
                    'key' => 'usuarios',
                    'title' => 'Usuarios',
                    'label' => 'Administrar usuarios',
                    'route' => route('profile'),
                    'active' => request()->routeIs('profile'),
                    'show' => $isEmployee,
                ],
            ])->filter(fn ($item) => $item['show']);
        @endphp

        <div x-data="{ sidebarOpen: true }" class="flex min-h-screen w-full">
            <aside
                class="relative z-20 flex w-72 flex-shrink-0 flex-col bg-slate-950/90 backdrop-blur transition-transform duration-200 lg:translate-x-0"
                :class="{ '-translate-x-full': !sidebarOpen }"
                x-cloak
            >
                <div class="flex items-center justify-between px-5 py-6">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-9 w-9 text-indigo-300" />
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Panel</p>
                            <p class="text-lg font-semibold text-slate-100">{{ config('app.name', 'Sistema') }}</p>
                        </div>
                    </div>

                    <button class="rounded-lg border border-gray-800 p-2 text-gray-400 hover:bg-gray-900 lg:hidden"
                            x-on:click="sidebarOpen = false">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 space-y-2 px-4">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['route'] }}"
                           wire:navigate
                           class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium transition
                           {{ $item['active'] ? 'bg-gradient-to-r from-indigo-600/30 via-purple-600/30 to-indigo-500/30 text-white shadow-inner shadow-indigo-900/40' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-indigo-200 transition
                                {{ $item['active'] ? 'border-indigo-400/60 bg-indigo-500/20 text-white' : 'group-hover:border-indigo-400/60 group-hover:bg-indigo-500/10 group-hover:text-indigo-100' }}">
                                @switch($item['key'])
                                    @case('dashboard')
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 17.25v-4.5A2.25 2.25 0 0 1 6 10.5h12a2.25 2.25 0 0 1 2.25 2.25v4.5M3.75 17.25A2.25 2.25 0 0 0 6 19.5h12a2.25 2.25 0 0 0 2.25-2.25M3.75 17.25v-9A2.25 2.25 0 0 1 6 6h12a2.25 2.25 0 0 1 2.25 2.25v9"/>
                                        </svg>
                                    @break

                                    @case('pacientes')
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 7.5a3 3 0 1 1 6 0m3.75 13.5a4.5 4.5 0 0 0-9 0M5.25 21a4.5 4.5 0 0 1 9 0"/>
                                        </svg>
                                    @break

                                    @case('personal')
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4.5 19.5a6 6 0 0 1 12 0"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M18.75 9.75v3m1.5-1.5h-3"/>
                                        </svg>
                                    @break

                                    @case('usuarios')
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.035a8.25 8.25 0 1 1 15 0"/>
                                        </svg>
                                    @break
                                @endswitch
                            </span>
                            <div class="leading-tight">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 group-hover:text-slate-200">
                                    {{ $item['title'] }}
                                </p>
                                <p class="text-base font-semibold">{{ $item['label'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </nav>

                <div class="px-4 pb-6">
                    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-indigo-500/10 to-transparent p-4 text-sm text-slate-400">
                        <p class="font-semibold text-slate-100">{{ $user?->name }}</p>
                        <p class="text-xs uppercase tracking-wide text-indigo-300">{{ $user?->roleName() }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-indigo-400/30 bg-indigo-500/10 px-3 py-2 text-sm font-semibold text-indigo-100 transition hover:bg-indigo-500/20">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9l3 3m0 0-3 3m3-3H3"/>
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex flex-1 flex-col">
                <header class="border-b border-white/5 bg-slate-900/60 backdrop-blur">
                    <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-4">
                            <button class="rounded-lg border border-white/10 p-2 text-slate-200 hover:bg-white/5 lg:hidden"
                                    x-on:click="sidebarOpen = true">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 5.25h16.5M3.75 12h16.5m-16.5 6.75h16.5"/>
                                </svg>
                            </button>

                            <div class="flex flex-col">
                                <span class="text-sm uppercase tracking-[0.35em] text-indigo-300/80">Bienvenida Doc</span>
                                <h1 class="text-2xl font-semibold text-slate-100">
                                    {{ $doctorName }}
                                </h1>
                                <p class="text-xs text-slate-400">{{ ucfirst($turnoHoy) }}</p>
                            </div>
                        </div>

                        <div class="flex flex-1 items-center justify-end">
                            <div class="flex w-full max-w-sm items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 shadow-sm shadow-indigo-500/10">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500/70 to-purple-500/70 text-white shadow-lg shadow-indigo-500/30">
                                    <span class="text-lg font-semibold">{{ \Illuminate\Support\Str::of($user?->name ?? '')->substr(0, 1)->upper() }}</span>
                                </div>
                                <div class="flex-1 leading-tight">
                                    <p class="font-semibold text-slate-100">{{ $user?->name }}</p>
                                    <p class="text-xs uppercase tracking-wide text-indigo-300">{{ $especialidadTexto }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 bg-transparent">
                    <div class="px-4 py-6 sm:px-6 lg:px-10">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @fluxScripts
    </body>
</html>

