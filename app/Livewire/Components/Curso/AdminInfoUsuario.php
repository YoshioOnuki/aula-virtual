<?php

namespace App\Livewire\Components\Curso;

use App\Models\Usuario;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy(isolate: false)]
class AdminInfoUsuario extends Component
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
                <div class="card placeholder-glow card-stacked">
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
                        <div class="placeholder placeholder col-8 mb-2"></div>
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
        return view('livewire.components.curso.admin-info-usuario');
    }
}
