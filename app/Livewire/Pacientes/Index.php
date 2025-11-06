<?php

namespace App\Livewire\Pacientes;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $q = '';
    public int $perPage = 10;

    public function render()
    {
        $items = User::query()
            ->pacientes()
            ->when($this->q, function ($q) {
                $t = '%'.$this->q.'%';
                $q->where(function ($w) use ($t) {
                    $w->where('last_name','like',$t)
                      ->orWhere('name','like',$t)
                      ->orWhere('email','like',$t)
                      ->orWhere('phone','like',$t);
                });
            })
            ->orderBy('last_name')
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.pacientes.index', compact('items'));
    }
}
