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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="">
            <div class="col-12 mb-3">
                <div class="card placeholder-glow animate__animated animate__fadeIn animate__faster">
                    <div class="progress card-progress h-2">
                        <div class="progress-bar bg-{{ $tipo_vista === 'cursos' ? 'teal-lt' : 'orange-lt' }}" style="width: 100%"
                            role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-auto">
                        <div class="avatar avatar-md avatar-thumb rounded placeholder"></div>
                        </div>
                        <div class="col">
                        <div class="placeholder placeholder-xs col-8"></div>
                        <div class="placeholder placeholder-xs col-9"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.components.info-alumnos-docentes');
    }
}
