<section class="mt-10 rounded-3xl border border-dashed border-white/20 bg-white/5 p-6 shadow-xl shadow-indigo-950/15 backdrop-blur">
    <header class="flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.35em] text-indigo-200/80">Documentación</p>
            <h3 class="mt-2 text-xl font-semibold text-white">README del panel</h3>
            <p class="text-sm text-slate-300/70">Guía rápida para que el equipo continúe el desarrollo</p>
        </div>
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-500/20 text-indigo-200">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 8.25V6a3 3 0 0 0-3-3h-3a3 3 0 0 0-3 3v2.25m9 0h3A2.25 2.25 0 0 1 21 10.5v9A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 19.5v-9A2.25 2.25 0 0 1 5.25 8.25h3m8.25 0h-8.25"/>
            </svg>
        </span>
    </header>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-sm text-slate-200">
            <h4 class="text-sm font-semibold uppercase tracking-wide text-indigo-200">Cómo levantar el entorno</h4>
            <ul class="mt-3 space-y-2 text-xs leading-relaxed text-slate-300/80">
                <li>1. Abrí una terminal para el frontend y ejecutá: <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">npm install</code> (solo la primera vez).</li>
                <li>2. Luego corré el servidor de estilos en esa terminal: <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">npm run dev</code>.</li>
                <li>3. En otra terminal, levantá el backend de Laravel: <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">php artisan serve</code>.</li>
                <li>4. Asegurate de tener la base de datos configurada en <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">.env</code> y migraciones/seeders ejecutados.</li>
            </ul>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-sm text-slate-200">
            <h4 class="text-sm font-semibold uppercase tracking-wide text-purple-200">Cambios realizados</h4>
            <ul class="mt-3 space-y-2 text-xs leading-relaxed text-slate-300/80">
                <li>• Se integró Laravel Fortify con roles basados en la tabla <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">tipo_persona</code> (Paciente / Profesional / Super Admin).</li>
                <li>• Se creó middleware <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">role</code> y helpers en el modelo <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">User</code> (hasRole, isEmployee).</li>
                <li>• Nuevo layout administrativo oscuro, menú lateral, tarjetas métricas y secciones de turnos.</li>
                <li>• Flujo interno para alta de empleados (Super Admin crea profesionales y staff).</li>
                <li>• Dashboard reorganizado con agenda diaria/próxima, gráfico semanal y formulario de turno rápido.</li>
            </ul>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-sm text-slate-200">
            <h4 class="text-sm font-semibold uppercase tracking-wide text-sky-200">Cómo funcionan los roles</h4>
            <ul class="mt-3 space-y-2 text-xs leading-relaxed text-slate-300/80">
                <li>• Los pacientes se registran vía formulario público y se les asigna el rol “Paciente”.</li>
                <li>• El Super Admin (sembrado o creado internamente) puede crear empleados:</li>
                <li class="pl-4 text-[11px] text-slate-400">- Rol “Profesional”: crea registro en <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">profesionales</code> y puede acceder a la gestión interna.</li>
                <li class="pl-4 text-[11px] text-slate-400">- Rol “Super Admin”: acceso total a panel, gestión de personal, pacientes y turnos.</li>
                <li>• Middleware <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">role</code> protege rutas (ej: `role:Super Admin,Profesional`).</li>
            </ul>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-sm text-slate-200">
            <h4 class="text-sm font-semibold uppercase tracking-wide text-violet-200">Para alinear dashboard con otros módulos</h4>
            <ul class="mt-3 space-y-2 text-xs leading-relaxed text-slate-300/80">
                <li>• Actualizar vistas de Pacientes / Personal / Turnos para que usen <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">x-admin-layout</code> y el mismo estilo oscuro.</li>
                <li>• Reutilizar la paleta (clases `bg-white/5`, `border-white/10`, gradientes Indigo/Violet) y tipografía.</li>
                <li>• Sustituir tablas simples por tarjetas/listados que sigan la estética (bordes redondeados, iconos minimalistas).</li>
                <li>• Mantener coordenadas responsivas (`grid`, `flex` con breakpoints) y componentes Livewire para formularios.</li>
            </ul>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-5 text-sm text-slate-200">
        <h4 class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Relaciones necesarias para mostrar profesiones</h4>
        <ul class="mt-3 space-y-2 text-xs leading-relaxed text-slate-300/80">
            <li>• Tabla <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">users</code> debe tener <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">tipo_persona_id</code> apuntando a “Super Admin” o “Profesional”.</li>
            <li>• Tabla <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">profesionales</code> se relaciona con <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">users</code> (columna <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">user_id</code>).</li>
            <li>• Tabla pivote <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">profesional_especialidad</code> vincula profesionales con sus especialidades.</li>
            <li>• Tabla <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">especialidads</code> (o la que uses) debe tener el nombre legible de la especialidad.</li>
            <li>• Para que aparezca en el panel, asegurate de que <code class="rounded bg-black/40 px-2 py-0.5 text-indigo-200">Profesional::especialidades()</code> devuelva la colección y que existan estos registros.</li>
        </ul>
    </div>
</section>

