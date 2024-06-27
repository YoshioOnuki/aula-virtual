<?php

namespace App\Livewire\Components;

use App\Models\Usuario;
use Livewire\Component;

class InfoAlumnosDocentes extends Component
{
    public $usuario;

    public function mount(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function render()
    {
        return view('livewire.components.info-alumnos-docentes');
    }
}
