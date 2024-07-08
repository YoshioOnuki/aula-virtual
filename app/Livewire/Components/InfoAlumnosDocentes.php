<?php

namespace App\Livewire\Components;

use App\Models\Usuario;
use Livewire\Component;

class InfoAlumnosDocentes extends Component
{
    public $usuario;
    public $tipo_vista;

    public function mount(Usuario $usuario, $tipo_vista)
    {
        $this->usuario = $usuario;
        $this->tipo_vista = $tipo_vista;
    }

    public function render()
    {
        return view('livewire.components.info-alumnos-docentes');
    }
}
