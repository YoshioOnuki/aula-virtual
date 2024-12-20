<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\ComentarioTrabajoAcademico;
use App\Models\EstadoTrabajoAcademico;
use App\Models\GestionAulaAlumno;
use App\Models\GestionAulaDocente;
use App\Models\TrabajoAcademicoAlumno;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardRevisarTrabajo extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula_docente;
    public $trabajo_academico_alumno;
    public $validar_entrega = false;
    public $editar_entrega = false;

    public $es_docente_invitado = false;
    public $estado_carga = true;

    // Variables para la revisión de trabajos
    #[Validate('required|numeric|min:0|max:20')]
    public $nota_trabajo_academico;
    #[Validate('required')]
    public $descripcion_comentario_trabajo_academico;


    /**
     * Revisar trabajo académico
     */
    public function revisar_trabajo_academico()
    {
        if ($this->es_docente_invitado) {
            $this->dispatch('permiso_denegado');
            return;
        }

        $this->validate([
            'nota_trabajo_academico' => 'required|numeric|min:0|max:20'
        ]);

        // dd($this->editar_entrega);

        try {
            DB::beginTransaction();

            $this->descripcion_comentario_trabajo_academico = limpiar_editor_vacio($this->descripcion_comentario_trabajo_academico);

            if ($this->editar_entrega) {
                $comentario_trabajo_academico = ComentarioTrabajoAcademico::where('id_trabajo_academico_alumno', $this->trabajo_academico_alumno->id_trabajo_academico_alumno)->first();
                if ($comentario_trabajo_academico) {
                    $comentario_trabajo_academico->descripcion_comentario_trabajo_academico = $this->descripcion_comentario_trabajo_academico;
                    $comentario_trabajo_academico->save();
                } else {
                    // Crear comentario nuevo
                    $comentario_trabajo_academico = new ComentarioTrabajoAcademico();
                    $comentario_trabajo_academico->descripcion_comentario_trabajo_academico = $this->descripcion_comentario_trabajo_academico;
                    $comentario_trabajo_academico->id_trabajo_academico_alumno = $this->trabajo_academico_alumno->id_trabajo_academico_alumno;
                    $comentario_trabajo_academico->id_gestion_aula_docente = $this->id_gestion_aula_docente;
                    $comentario_trabajo_academico->save();
                }


            } else{
                if ($this->descripcion_comentario_trabajo_academico !== '') {
                    // Crear comentario nuevo
                    $comentario_trabajo_academico = new ComentarioTrabajoAcademico();
                    $comentario_trabajo_academico->descripcion_comentario_trabajo_academico = $this->descripcion_comentario_trabajo_academico;
                    $comentario_trabajo_academico->id_trabajo_academico_alumno = $this->trabajo_academico_alumno->id_trabajo_academico_alumno;
                    $comentario_trabajo_academico->id_gestion_aula_docente = $this->id_gestion_aula_docente;
                    $comentario_trabajo_academico->save();
                }
            }

            $comentario_trabajo_academico = ComentarioTrabajoAcademico::where('id_trabajo_academico_alumno', $this->trabajo_academico_alumno->id_trabajo_academico_alumno)->first();
            $nombre_estado_trabajo_academico = $comentario_trabajo_academico ? 'Observado' : 'Revisado';
            $id_estado_trabajo_academico = EstadoTrabajoAcademico::where('nombre_estado_trabajo_academico', $nombre_estado_trabajo_academico)->first()->id_estado_trabajo_academico;

            $tramite_trabajo_academico_alumno = TrabajoAcademicoAlumno::find($this->trabajo_academico_alumno->id_trabajo_academico_alumno);
            $tramite_trabajo_academico_alumno->nota_trabajo_academico_alumno = $this->nota_trabajo_academico;
            $tramite_trabajo_academico_alumno->id_estado_trabajo_academico = $id_estado_trabajo_academico;
            $tramite_trabajo_academico_alumno->save();

            DB::commit();

            $this->estado_carga = true;

            $this->dispatch(
                'toast-basico',
                mensaje: 'Se ha revisado el trabajo académico correctamente.',
                type: 'success'
            );

            $this->dispatch('$refresh');

            $this->dispatch('actualizar_estado_entrega');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al revisar el trabajo académico.',
                tipo: 'error'
            );
        }
    }


    /**
     * Cargar datos del trabajo académico (nota y comentario)
     */
    public function cargar_datos()
    {
        if ($this->trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico !== 'Entregado') {
            $this->nota_trabajo_academico = $this->trabajo_academico_alumno->nota_trabajo_academico_alumno;

            $comentario_trabajo_academico = ComentarioTrabajoAcademico::where('id_trabajo_academico_alumno', $this->trabajo_academico_alumno->id_trabajo_academico_alumno)->first();
            $this->descripcion_comentario_trabajo_academico = $comentario_trabajo_academico ? $comentario_trabajo_academico->descripcion_comentario_trabajo_academico : '';
        }
        $this->estado_carga = false;
    }


    /**
     * Validar si el trabajo académico ha sido entregado
     */
    public function funcion_validar_entrega()
    {
        $this->trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico === 'Entregado' ? $this->validar_entrega = true : $this->validar_entrega = false;
    }


    /**
     * Actualizar datos de la entrega del trabajo académico
     */
    #[On('actualizar_estado_entrega_alumno')]
    public function actualizar_estado_entrega_alumno()
    {
        $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::find($this->trabajo_academico_alumno->id_trabajo_academico_alumno);
        $this->cargar_datos();
        $this->funcion_validar_entrega();
        $this->estado_carga = false;
    }


    /**
     * Placeholder para la carga de datos
     */
    public function placeholder()
    {
        return <<<'HTML'
        <div class="card card-stacked placeholder-glow">
            <div class="card-header bg-orange-lt">
                <div class="placeholder col-8 bg-orange"
                style="height: 1.5rem;"></div>
            </div>
            <div class="card-body row g-3">
                <table class="table table-striped table-vcenter">
                    <tbody>
                        <div class="placeholder placeholder-xs col-2 mt-4"></div>
                        <div class="placeholder placeholder-lg col-12 bg-secondary" style="height: 1.6rem;"></div>
                        <div class="placeholder placeholder-xs col-8 mt-4"></div>
                        <div class="placeholder placeholder-lg col-12 bg-secondary" style="height: 10rem;"></div>

                        <a href="#" tabindex="-1"
                            class="btn btn-primary disabled placeholder col-12 d-block mt-5"
                            aria-hidden="true"></a>
                    </tbody>
                </table>
            </div>
        </div>
        HTML;
    }


    public function mount($tipo_vista, $usuario, $id_gestion_aula_docente, $trabajo_academico_alumno)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_docente = $id_gestion_aula_docente;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);

        $this->trabajo_academico_alumno = $trabajo_academico_alumno;

        $id_gestion_aula = GestionAulaDocente::find($id_gestion_aula_docente)->id_gestion_aula;
        $this->es_docente_invitado = $usuario->esDocenteInvitado($id_gestion_aula) && $tipo_vista === 'carga-academica' ? true : false;

        $this->cargar_datos();
        $this->funcion_validar_entrega();
    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-revisar-trabajo');
    }
}
