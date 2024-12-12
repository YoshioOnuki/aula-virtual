<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\GestionAulaAlumno;
use App\Models\TrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use App\Traits\UsuarioTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class CardEstadoTrabajo extends Component
{
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;
    public $tipo_vista;
    public $id_gestion_aula;
    public $id_gestion_aula_alumno;
    public $trabajo_academico;

    public $trabajo_academico_alumno;
    public $cantidad_comentarios;

    public $cantidad_alumnos;
    public $cantidad_alumnos_entregados;
    public $cantidad_alumnos_revisados;
    public $cantidad_alumnos_observados;

    public bool $lista_alumnos;


    /**
     * Evento para abrir el modal de comentarios
     */
    public function abrir_modal_comentarios()
    {
        $this->dispatch('abrir-modal-comentarios');
    }


    /**
     * Actualizar estado del trabajo académico
     */
    #[On('actualizar_estado_trabajo')]
    public function actualizar_estado_trabajo()
    {
        if ($this->tipo_vista === 'carga-academica')
        {
            // Cantidad de alumnos que han entregado el trabajo
            $this->cantidad_alumnos_entregados = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->count();

            // Cantidad de alumnos que han sido revisados
            $this->cantidad_alumnos_revisados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->whereHas('estadoTrabajoAcademico', function ($query) {
                    $query->where('nombre_estado_trabajo_academico', '!=', 'Entregado');
                })
                ->count();

            // Cantidad de alumnos que han sido observados
            $this->cantidad_alumnos_observados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->whereHas('estadoTrabajoAcademico', function ($query) {
                    $query->where('nombre_estado_trabajo_academico', 'Observado');
                })
                ->count();

            // Cantida de alumnos del curso
            $this->cantidad_alumnos = GestionAulaAlumno::where('id_gestion_aula', $this->id_gestion_aula)
                ->estado(true)
                ->count();
        }else{
            $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->where('id_gestion_aula_alumno', $this->id_gestion_aula_alumno)
                ->first();
        }
    }


    /**
     * Placeholder para la carga diferida de la vista
     */
    public function placeholder()
    {
        return <<<'HTML'
        <div class="card card-stacked placeholder-glow">
            <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                <div class="placeholder col-5 {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"
                style="height: 1.5rem; width: 170.56px;"></div>
            </div>
            <div class="card-body row g-3 mb-0">
                <table class="table table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <div class="placeholder placeholder col-12"></div>
                            </th>
                            <td>
                                <div class="placeholder placeholder col-12"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="placeholder placeholder col-12"></div>
                            </th>
                            <td>
                                @if($tipo_vista === 'cursos')
                                    <div class="placeholder placeholder col-12"></div>
                                @else
                                    <div class="mb-1">
                                        <div class="placeholder placeholder col-12"></div>
                                    </div>
                                    <div>
                                        <div class="placeholder placeholder col-12"></div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="placeholder placeholder col-12"></div>
                            </th>
                            <td>
                                <div class="placeholder placeholder col-12"></div>
                            </td>
                        </tr>
                        @if($tipo_vista === 'cursos')
                            <tr>
                                <th scope="row">
                                <div class="placeholder placeholder col-12"></div>
                                </th>
                                <td>
                                <div class="placeholder placeholder col-12"></div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                <div class="placeholder placeholder col-12"></div>
                                </th>
                                <td>
                                    <a href="#">
                                <div class="placeholder placeholder col-12"></div>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if($tipo_vista === 'carga-academica' && $lista_alumnos === true)
                    <a href="#" tabindex="-1"
                        class="btn btn-primary disabled placeholder col-12 d-block"
                        aria-hidden="true"></a>
                @endif
            </div>
        </div>
        HTML;
    }


    public function mount($id_usuario_hash, $tipo_vista, $id_curso, TrabajoAcademico $trabajo_academico, $lista_alumnos)
    {
        $this->id_usuario_hash = $id_usuario_hash;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario_hash);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula = $id_curso;
        $this->trabajo_academico = $trabajo_academico;
        $this->lista_alumnos = $lista_alumnos;
        $this->id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
        ->gestionAula($this->id_gestion_aula)
        ->first()
        ->id_gestion_aula_alumno ?? null;

        if ($this->tipo_vista === 'carga-academica')
        {
            // Cantidad de alumnos que han entregado el trabajo
            $this->cantidad_alumnos_entregados = TrabajoAcademicoAlumno::where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->count();

            // Cantidad de alumnos que han sido revisados
            $this->cantidad_alumnos_revisados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->whereHas('estadoTrabajoAcademico', function ($query) {
                    $query->where('nombre_estado_trabajo_academico',  '!=', 'Entregado');
                })
                ->count();

            // Cantidad de alumnos que han sido observados
            $this->cantidad_alumnos_observados = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->whereHas('estadoTrabajoAcademico', function ($query) {
                    $query->where('nombre_estado_trabajo_academico', 'Observado');
                })
                ->count();

            // Cantida de alumnos del curso
            $this->cantidad_alumnos = GestionAulaAlumno::where('id_gestion_aula', $this->id_gestion_aula)
                ->estado(true)
                ->count();
        }else{
            $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::with('comentarioTrabajoAcademico')
                ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                ->where('id_gestion_aula_alumno', $this->id_gestion_aula_alumno)
                ->first() ?? null;

            $this->cantidad_comentarios = $this->trabajo_academico_alumno ? $this->trabajo_academico_alumno->comentarioTrabajoAcademico->count() : 0;
        }
    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-estado-trabajo');
    }
}
