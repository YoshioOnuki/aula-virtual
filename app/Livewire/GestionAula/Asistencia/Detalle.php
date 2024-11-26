<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\AsistenciaAlumno;
use App\Models\EstadoAsistencia;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\Persona;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Detalle extends Component
{
    use WithPagination;
    use UsuarioTrait;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;

    public $id_asistencia;

    // Variables para el modal de enviar asistencia
    public $titulo_modal_enviar = 'Enviar Asistencia';
    public $modo_enviar = 0; // 0: Enviar asistencia a un solo alumno, 1: Enviar asistencia a varios alumnos
    public $id_asistencia_enviar;
    public $estado_asistencia;
    public $estados = [];
    public $tipo_asistencia_a_enviar;
    public $fecha_asistencia_a_enviar;
    public $hora_inicio_asistencia_a_enviar;
    public $hora_fin_asistencia_a_enviar;
    public $id_gestion_aula_enviar;

    public $check_alumno = [];
    public $check_all = false;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $estado_carga_modal = true; // Para manejar el estado de carga del modal
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Actualizar check_all
     */
    public function updatedCheckAll($value)
    {
        $alumnos = GestionAulaAlumno::with('asistenciaAlumno')
            ->gestionAula($this->id_gestion_aula)
            // que no tenga registros en la tabla asistencia_alumno
            ->whereDoesntHave('asistenciaAlumno', function ($query) {
                $query->where('id_asistencia', $this->id_asistencia);
            })
            ->get();

        if ($value) {
            // Marcar todos los checks true
            foreach ($alumnos as $alumno) {
                $this->check_alumno[$alumno->id_gestion_aula_alumno] = true;
            }
        } else {
            // Desmarcar todos los checks false
            foreach ($alumnos as $alumno) {
                $this->check_alumno[$alumno->id_gestion_aula_alumno] = false;
            }
        }
    }


    /**
     * Abrir modal para enviar asistencia
     */
    public function abrir_modal_enviar_asistencia($id_gestion_aula_alumno)
    {
        $this->limpiar_modal();

        $this->titulo_modal_enviar = 'Enviar Asistencia';
        $this->modo_enviar = 0; // Enviar asistencia a un solo alumno

        $this->id_gestion_aula_enviar = $id_gestion_aula_alumno;
        $this->id_asistencia_enviar = $this->id_asistencia;
        $asistencia = Asistencia::find($this->id_asistencia);

        $this->estados = EstadoAsistencia::estado(true)->get();
        $this->tipo_asistencia_a_enviar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
        $this->fecha_asistencia_a_enviar = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia_a_enviar = $asistencia->hora_inicio_asistencia;
        $this->hora_fin_asistencia_a_enviar = $asistencia->hora_fin_asistencia;

        $this->estado_carga_modal = false;
    }


    /**
     * Abrir modal para enviar asistencia
     */
    public function abrir_modal_enviar_asistencias()
    {
        $this->limpiar_modal();

        $this->titulo_modal_enviar = 'Enviar varias asistencias';
        $this->modo_enviar = 1; // Enviar asistencia a varios alumnos

        $this->id_asistencia_enviar = $this->id_asistencia;
        $asistencia = Asistencia::find($this->id_asistencia);

        $this->estados = EstadoAsistencia::estado(true)->get();
        $this->tipo_asistencia_a_enviar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
        $this->fecha_asistencia_a_enviar = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia_a_enviar = $asistencia->hora_inicio_asistencia;
        $this->hora_fin_asistencia_a_enviar = $asistencia->hora_fin_asistencia;

        $this->estado_carga_modal = false;
    }


    /**
     * Enviar asistencia
     */
    public function enviar_asistencia()
    {
        $this->validate([
            'estado_asistencia' => 'required'
        ]);

        try {
            DB::beginTransaction();

            if (count($this->check_alumno) > 0 && $this->modo_enviar === 1) {
                // Eliminar los checks falsos
                $this->check_alumno = array_filter($this->check_alumno);
                // Sacar los alumnos seleccionados por sus indices
                $this->check_alumno = array_keys($this->check_alumno);
                foreach ($this->check_alumno as $id_gestion_aula_alumno) {
                    $asistencia_alumno = new AsistenciaAlumno();
                    $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                    $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                    // Asignar el indice del check como id_gestion_aula_alumno
                    $asistencia_alumno->id_gestion_aula_alumno = $id_gestion_aula_alumno;
                    $asistencia_alumno->save();
                }
            } else if ($this->modo_enviar === 1 && count($this->check_alumno) <= 0) {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se ha seleccionado ningún alumno.',
                    type: 'error'
                );
                $this->cerrar_modal('#modal-enviar-asistencias');
                $this->limpiar_modal();

                return;
            } else {
                $asistencia_alumno = new AsistenciaAlumno();
                $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                $asistencia_alumno->id_gestion_aula_alumno = $this->id_gestion_aula_enviar;
                $asistencia_alumno->save();
            }

            // Limpiar los checks
            $this->check_alumno = [];
            $this->check_all = false;

            DB::commit();

            $this->cerrar_modal('#modal-enviar-asistencias');
            $this->limpiar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'La asistencia se ha enviado correctamente',
                type: 'success'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al enviar la asistencia.' . $e->getMessage(),
                type: 'error'
            );
        }
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal)
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    /**
     * Limpiar modal
     */
    public function limpiar_modal()
    {
        $this->estado_carga_modal = true;

        $this->id_asistencia_enviar = null;
        $this->estado_asistencia = '';
        $this->tipo_asistencia_a_enviar = '';
        $this->fecha_asistencia_a_enviar = '';
        $this->hora_inicio_asistencia_a_enviar = '';
        $this->hora_fin_asistencia_a_enviar = '';
        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener datos para mostrar en el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Detalle de Asistencia';

        // Regresar
        $this->regresar_page_header = [
            'route' => 'carga-academica.detalle.asistencia',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
        ];

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];

        // Links --> Carga Académica
        $this->links_page_header[] = [
            'name' => 'Carga Académica',
            'route' => 'carga-academica',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
        ];

        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);
        $nombre_curso = $gestion_aula->curso->nombre_curso . ' GRUPO ' . $gestion_aula->grupo_gestion_aula;

        // Links --> Detalle de la carga académica
        $this->links_page_header[] = [
            'name' => $nombre_curso,
            'route' => 'carga-academica.detalle',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
        ];

        // Links --> Asistencia
            $this->links_page_header[] = [
            'name' => 'Asistencia',
            'route' => 'carga-academica.detalle.asistencia',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
        ];
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_asistencia)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->id_asistencia = Hashids::decode($id_asistencia)[0];

        $this->obtener_datos_page_header();

        $alumnos = GestionAulaAlumno::with('asistenciaAlumno')
            ->gestionAula($this->id_gestion_aula)
            // que no tenga registros en la tabla asistencia_alumno
            ->whereDoesntHave('asistenciaAlumno', function ($query) {
                $query->where('id_asistencia', $this->id_asistencia);
            })
            ->get();

        foreach ($alumnos as $alumno) {
            $this->check_alumno[$alumno->id_gestion_aula_alumno] = false;
        }

        $this->check_all = false;
    }


    public function render()
    {
        $alumnos = Persona::with([
            'usuario' => function ($query) {
                $query->with([
                    'gestionAulaAlumno' => function ($query) {
                        $query->with(['asistenciaAlumno' => function ($query) {
                            $query->where('id_asistencia', $this->id_asistencia);
                        }])
                            ->where('id_gestion_aula', $this->id_gestion_aula);
                    }
                ]);
            }
        ])
            ->whereHas('usuario.gestionAulaAlumno', function ($query) {
                $query->where('id_gestion_aula', $this->id_gestion_aula);
            })
            ->search($this->search)
            ->orderBy('nombres_persona', 'asc')
            ->orderBy('apellido_paterno_persona', 'asc')
            ->orderBy('apellido_materno_persona', 'asc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.asistencia.detalle', [
            'alumnos' => $alumnos
        ]);
    }
}
