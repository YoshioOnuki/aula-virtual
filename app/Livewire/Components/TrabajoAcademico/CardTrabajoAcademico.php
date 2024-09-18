<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardTrabajoAcademico extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_gestion_aula_usuario;
    public $trabajo_academico;

    public $id_usuario_hash;

    protected $listeners = ['actualizar-trabajos-academicos' => 'mostrar_trabajos'];


    public function abrir_modal($id_trabajo_academico)
    {
        $this->dispatch('abrir-modal-trabajo-editar', $id_trabajo_academico);
    }


    public function mostrar_trabajos()
    {
        $this->mount($this->tipo_vista, $this->usuario, $this->id_gestion_aula_usuario, $this->trabajo_academico);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="col-12">
            <div class="card placeholder-glow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-5">
                        <div class="placeholder col-6" style="height: 1.5rem;"></div>
                        <div class="placeholder"></div>
                    </div>
                    <div>
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                    </div>
                    <div class=" d-flex justify-content-end">
                        @if ($tipo_vista === 'carga-academica' &&
                        $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                        <a href="#" tabindex="-1"
                            class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block"
                            aria-hidden="true"></a>
                        <a href="#" tabindex="-1"
                            class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon"
                            aria-hidden="true"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }


    public function mount($tipo_vista, $usuario, $id_gestion_aula_usuario, $trabajo_academico)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);
        $this->trabajo_academico = TrabajoAcademico::with([
            'trabajoAcademicoAlumno' => function ($query) {
                $query->with('estadoTrabajoAcademico')
                    ->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
                    ->first();
            }
        ])->find($trabajo_academico->id_trabajo_academico);
        // dd($this->trabajo_academico);
    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-trabajo-academico');
    }
}
