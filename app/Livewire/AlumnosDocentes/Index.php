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
        if(request()->routeIs('cursos*'))
        {
            $this->tipo_vista = 'alumno';
        }elseif(request()->routeIs('carga-academica*'))
        {
            $this->tipo_vista = 'docente';
        }elseif(request()->routeIs('alumnos*'))
        {
            $this->tipo_vista = 'alumno';
        }elseif(request()->routeIs('docentes*'))
        {
            $this->tipo_vista = 'docente';
        }

    }

    public function render()
    {
        return view('livewire.alumnos-docentes.index');
    }
}
