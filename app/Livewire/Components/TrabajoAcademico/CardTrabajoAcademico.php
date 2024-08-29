<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardTrabajoAcademico extends Component
{
    public $trabajos_academicos;
    public $tipo_vista;
    public $usuario;
    public $id_gestion_aula_usuario;

    public $id_usuario_hash;

    protected $listeners = ['actualizar-trabajos-academicos' => 'mostrar_trabajos'];


    public function abrir_modal($id_trabajo_academico)
    {
        $this->dispatch('abrir-modal-editar', $id_trabajo_academico);
    }


    /* =============== OBTENER DATOS PARA MOSTRAR LOS TRABAJOS =============== */
        public function mostrar_trabajos()
        {
            $gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'curso' => function ($query) {
                            $query->with([
                                'ciclo',
                                'planEstudio',
                                'programa' => function ($query) {
                                    $query->with([
                                        'facultad',
                                        'tipoPrograma'
                                    ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                                }
                            ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
                        },
                        'trabajoAcademico' => function ($query) {
                            $query->with([
                                'archivoDocente' => function ($query) {
                                    $query->get();
                                },
                                'trabajoAcademicoAlumno' => function ($query) {
                                    $query->with([
                                        'archivoAlumno' => function ($query) {
                                            $query->get();
                                        },
                                        'estadoTrabajoAcademico' => function ($query) {
                                            $query->first();
                                        },
                                        'comentarioTrabajoAcademico' => function ($query) {
                                            $query->get();
                                        }
                                    ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->get();
                                },
                            ])->orderBy('fecha_inicio_trabajo_academico', 'DESC')
                                ->get();
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
                ->first();

            if ($gestion_aula_usuario) {
                $this->trabajos_academicos = $gestion_aula_usuario->gestionAula->trabajoAcademico;
            }
        }
    /* ======================================================================= */


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


    public function mount($tipo_vista, $usuario, $id_gestion_aula_usuario)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);

        $this->mostrar_trabajos();
    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-trabajo-academico');
    }
}
