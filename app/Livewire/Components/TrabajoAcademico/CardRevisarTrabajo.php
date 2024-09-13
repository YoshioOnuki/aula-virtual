<?php

namespace App\Livewire\Components\TrabajoAcademico;

use App\Models\ComentarioTrabajoAcademico;
use App\Models\EstadoTrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class CardRevisarTrabajo extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula_usuario;
    public $trabajo_academico_alumno;

    // Variables para la revisión de trabajos
    #[Validate('required|numeric|min:0|max:20')]
    public $nota_trabajo_academico;
    #[Validate('required')]
    public $descripcion_comentario_trabajo_academico;


    public function revisar_trabajo_academico()
    {
        $this->validate([
            'nota_trabajo_academico' => 'required|numeric|min:0|max:20'
        ]);

        try
        {
            DB::beginTransaction();

            $this->descripcion_comentario_trabajo_academico = contenido_vacio($this->descripcion_comentario_trabajo_academico);

            if ($this->descripcion_comentario_trabajo_academico !== '') {
                // Crear comentario nuevo
                $comentario_trabajo_academico = new ComentarioTrabajoAcademico();
                $comentario_trabajo_academico->descripcion_comentario_trabajo_academico = $this->descripcion_comentario_trabajo_academico;
                $comentario_trabajo_academico->id_trabajo_academico_alumno = $this->trabajo_academico_alumno->id_trabajo_academico_alumno;
                $comentario_trabajo_academico->id_gestion_aula_usuario = $this->id_gestion_aula_usuario;
                $comentario_trabajo_academico->save();
            }

            $comentario_trabajo_academico = ComentarioTrabajoAcademico::where('id_trabajo_academico_alumno', $this->trabajo_academico_alumno->id_trabajo_academico_alumno)->first();
            $nombre_estado_trabajo_academico = $comentario_trabajo_academico ? 'Observado' : 'Revisado';
            $id_estado_trabajo_academico = EstadoTrabajoAcademico::where('nombre_estado_trabajo_academico', $nombre_estado_trabajo_academico)->first()->id_estado_trabajo_academico;

            $tramite_trabajo_academico_alumno = TrabajoAcademicoAlumno::find($this->trabajo_academico_alumno->id_trabajo_academico_alumno);
            $tramite_trabajo_academico_alumno->nota_trabajo_academico_alumno = $this->nota_trabajo_academico;
            $tramite_trabajo_academico_alumno->id_estado_trabajo_academico = $id_estado_trabajo_academico;
            $tramite_trabajo_academico_alumno->save();


            DB::commit();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Se ha revisado el trabajo académico correctamente.',
                type: 'success'
            );

            $this->cargar_datos();

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al revisar el trabajo académico.',
                tipo: 'error'
            );
        }
    }


    public function cargar_datos()
    {
        if($this->trabajo_academico_alumno->estadoTrabajoAcademico->nombre_estado_trabajo_academico !== 'Entregado') {
            $this->nota_trabajo_academico = $this->trabajo_academico_alumno->nota_trabajo_academico_alumno;

            $comentario_trabajo_academico = ComentarioTrabajoAcademico::where('id_trabajo_academico_alumno', $this->trabajo_academico_alumno->id_trabajo_academico_alumno)->first();
            $this->descripcion_comentario_trabajo_academico = $comentario_trabajo_academico ? $comentario_trabajo_academico->descripcion_comentario_trabajo_academico : '';
        }
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


    public function mount($tipo_vista, $usuario, $id_gestion_aula_usuario, $trabajo_academico_alumno)
    {
        $this->tipo_vista = $tipo_vista;
        $this->usuario = $usuario;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);

        $this->trabajo_academico_alumno = $trabajo_academico_alumno;

        $this->cargar_datos();
    }


    public function render()
    {
        return view('livewire.components.trabajo-academico.card-revisar-trabajo');
    }
}
