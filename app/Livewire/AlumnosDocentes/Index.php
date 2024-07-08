<?php

namespace App\Livewire\AlumnosDocentes;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    public $tipo_vista;

    public function mount()
    {
        if(request()->routeIs('alumnos*'))
        {
            $this->tipo_vista = 'cursos';
        }elseif(request()->routeIs('docentes*'))
        {
            $this->tipo_vista = 'carga-academica';
        }

    }

    public function render()
    {
        return view('livewire.alumnos-docentes.index');
    }
}
