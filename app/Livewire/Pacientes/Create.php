<?php

namespace App\Livewire\Pacientes;

use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    #[Validate('required|string|min:2|max:255')] public string $name = '';
    #[Validate('required|string|min:2|max:255')] public string $last_name = '';
    #[Validate('required|email|max:255|unique:users,email')] public string $email = '';
    #[Validate('nullable|string|max:255')] public ?string $phone = null;
    #[Validate('nullable|date')] public ?string $birthdate = null;

    public function save(): void
    {
        $this->validate();

        $tipoPacienteId = \App\Models\TipoPersona::where('nombre_tipo','Paciente')->value('id');

        User::create([
            'name'            => $this->name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'birthdate'       => $this->birthdate,
            'tipo_persona_id' => $tipoPacienteId,
            'password'        => Hash::make('paciente123'),
        ]);

        session()->flash('ok','Paciente creado.');
        $this->redirectRoute('pacientes.index', navigate: true);
    }

    public function render() { return view('livewire.pacientes.create'); }
}
