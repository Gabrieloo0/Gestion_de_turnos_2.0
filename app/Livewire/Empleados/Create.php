<?php

namespace App\Livewire\Empleados;

use App\Models\Profesional;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|string|min:2|max:255')]
    public string $last_name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('nullable|string|max:255')]
    public ?string $phone = null;

    #[Validate('nullable|date')]
    public ?string $birthdate = null;

    #[Validate('required|string|in:Super Admin,Profesional')]
    public string $role = 'Profesional';

    #[Validate('nullable|string|max:255')]
    public ?string $matricula = null;

    #[Validate('required|string|min:8')]
    public string $password = '';

    public function updatedRole(): void
    {
        if ($this->role !== 'Profesional') {
            $this->matricula = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        $roleModel = TipoPersona::firstWhere('nombre_tipo', $this->role);

        if (! $roleModel) {
            $this->addError('role', 'El rol seleccionado no existe. Verificá el catálogo de roles.');
            return;
        }

        DB::transaction(function () use ($roleModel) {
            $user = User::create([
                'name'            => $this->name,
                'last_name'       => $this->last_name,
                'email'           => $this->email,
                'phone'           => $this->phone,
                'birthdate'       => $this->birthdate,
                'password'        => Hash::make($this->password),
                'tipo_persona_id' => $roleModel->id,
            ]);

            if ($this->role === 'Profesional') {
                Profesional::create([
                    'user_id'   => $user->id,
                    'matricula' => $this->matricula,
                ]);
            }
        });

        session()->flash('ok', 'Empleado creado correctamente.');
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        $roles = TipoPersona::whereIn('nombre_tipo', ['Super Admin', 'Profesional'])
            ->orderBy('nombre_tipo')
            ->get();

        return view('livewire.empleados.create', [
            'roles' => $roles,
        ]);
    }
}

