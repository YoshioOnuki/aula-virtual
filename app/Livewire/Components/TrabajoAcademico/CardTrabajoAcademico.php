<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\GestionAulaAlumno;
use App\Models\TrabajoAcademico;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Lazy(isolate: false)]
class CardTrabajoAcademico extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula;
    public $id_gestion_aula_alumno;
    public $trabajo_academico;
    public $es_docente;


    /**
     * Evento para abrir modal de edición de trabajo académico
     */
    public function abrir_modal($id_trabajo_academico)
    {
        $this->dispatch('abrir-modal-trabajo-editar', $id_trabajo_academico);
    }


    /**
     * Actualizar trabajos académicos
     */
    #[On('actualizar-trabajos-academicos')]
    public function mostrar_trabajos()
    {
        $this->mount($this->tipo_vista, $this->usuario, $this->id_gestion_aula, $this->trabajo_academico);
    }


    /**
     * Placeholder para mostrar mientras se cargan los datos
     */
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
                        $usuario->esDocente($id_gestion_aula))
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


    public function mount($tipo_vista, $usuario, $id_curso, $trabajo_academico)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula = $id_curso;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);
        $this->id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $usuario->id_usuario)
            ->gestionAula($this->id_gestion_aula)
            ->first()
            ->id_gestion_aula_alumno ?? null;

        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);

        $this->trabajo_academico = TrabajoAcademico::with([
            'trabajoAcademicoAlumno' => function ($query) {
                $query->with('estadoTrabajoAcademico')
                    ->where('id_gestion_aula_alumno', $this->id_gestion_aula_alumno)
                    ->first();
            }
        ])->find($trabajo_academico->id_trabajo_academico);

    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-trabajo-academico');
    }
}
