<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\AsistenciaAlumno;
use App\Models\EstadoAsistencia;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\GestionAulaDocente;
use App\Models\TipoAsistencia;
use App\Traits\UsuarioTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    use UsuarioTrait;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $id_gestion_aula_alumno;
    public $id_gestion_aula_docente;

    public $es_docente = false;
    public $es_docente_invitado = false;

    // Variables para el modal de Asistencias
    public $modo_asistencias = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_asistencias = 'Agregar Link de Clase';
    public $accion_asistencias = 'Agregar';
    public $id_asistencia_editar;
    #[Validate('required')]
    public $tipo_asistencia;
    #[Validate('required|date|after_or_equal:today')]
    public $fecha_asistencia;
    public $fecha_asistencia_temporal;
    #[Validate('required|date_format:H:i')]
    public $hora_inicio_asistencia;
    #[Validate('required|date_format:H:i|after:hora_inicio_asistencia')]
    public $hora_fin_asistencia;

    // Variables para el modal de eliminar
    public $id_asistencia_a_eliminar;
    public $tipo_asistencia_a_eliminar;
    public $fecha_asistencia_a_eliminar;
    public $hora_inicio_asistencia_a_eliminar;
    public $hora_fin_asistencia_a_eliminar;

    // Variables para el modal de enviar asistencia
    public $id_asistencia_enviar;
    public $estado_asistencia;
    public $estados = [];
    public $tipo_asistencia_a_enviar;
    public $fecha_asistencia_a_enviar;
    public $hora_inicio_asistencia_a_enviar;
    public $hora_fin_asistencia_a_enviar;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;


    protected $messages = [
        'tipo_asistencia.required' => 'El campo tipo de asistencia es obligatorio.',
        'fecha_asistencia.after_or_equal' => 'El campo fecha de asistencia debe ser una fecha posterior o igual a hoy.',
        'hora_fin_asistencia.after' => 'El campo hora de fin debe ser una hora posterior a la hora de inicio.',
    ];


    /**
     * Actualizar la vista de la paginación en tiempo real
     */
    public function updatingMostrarPaginate()
    {
        $this->resetPage();
    }



    /**
     * Abrir modal para agregar asistencia
     */
    public function abrir_modal_asistencias_agregar()
    {
        $this->limpiar_modal();

        $this->modo_asistencias = 1; // Agregar
        $this->titulo_asistencias = 'Agregar Asistencia';
        $this->accion_asistencias = 'Agregar';
    }


    /**
     * Abrir modal para editar asistencia
     */
    public function abrir_modal_asistencias_editar(Asistencia $asistencia)
    {
        $this->limpiar_modal();

        $this->modo_asistencias = 0; // Editar
        $this->titulo_asistencias = 'Editar Asistencia';
        $this->accion_asistencias = 'Editar';

        $this->id_asistencia_editar = $asistencia->id_asistencia;
        $this->tipo_asistencia = $asistencia->id_tipo_asistencia;
        $this->fecha_asistencia = Carbon::parse($asistencia->fecha_asistencia)->format('Y-m-d');
        $this->fecha_asistencia_temporal = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia = Carbon::createFromFormat('H:i:s', $asistencia->hora_inicio_asistencia)->format('H:i');
        $this->hora_fin_asistencia = Carbon::createFromFormat('H:i:s', $asistencia->hora_fin_asistencia)->format('H:i');
    }


    /**
     * Guardar asistencia
     */
    public function guardar_asistencias()
    {
        $this->validate([
            'tipo_asistencia' => 'required',
            'fecha_asistencia' => 'required|date|after_or_equal:today',
            'hora_inicio_asistencia' => 'required|date_format:H:i',
            'hora_fin_asistencia' => 'required|date_format:H:i|after:hora_inicio_asistencia',
        ]);

        if ($this->validate_hora_inicio() && $this->modo_asistencias == 1) {
            $this->addError('hora_inicio_asistencia', 'La hora de inicio no puede ser menor a la hora actual.');
        } else {
            try {
                DB::beginTransaction();

                if ($this->modo_asistencias == 1) // Agregar
                {
                    $this->agregar_asistenca();
                } else {
                    $this->editar_asistencia();
                }

                DB::commit();

                $this->cerrar_modal('#modal-asistencia');
                $this->limpiar_modal();

                $this->dispatch(
                    'toast-basico',
                    mensaje: 'La asistencia se ha guardado correctamente',
                    type: 'success'
                );
            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e);
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Ha ocurrido un error al guardar la asistencia: ',
                    type: 'error'
                );
            }
        }
    }


    /**
     * Agregar asistencia
     */
    public function agregar_asistenca()
    {
        $asistencia = new Asistencia();
        $asistencia->fecha_asistencia = $this->fecha_asistencia;
        $hora_inicio = Carbon::createFromFormat('H:i', $this->hora_inicio_asistencia);
        $asistencia->hora_inicio_asistencia = $hora_inicio->format('H:i:s');
        $hora_fin = Carbon::createFromFormat('H:i', $this->hora_fin_asistencia);
        $asistencia->hora_fin_asistencia = $hora_fin->format('H:i:s');
        $asistencia->id_tipo_asistencia = $this->tipo_asistencia;
        $asistencia->id_gestion_aula = $this->id_gestion_aula;
        $asistencia->save();
    }


    /**
     * Editar asistencia
     */
    public function editar_asistencia()
    {
        $asistencia = Asistencia::find($this->id_asistencia_editar);
        $asistencia->fecha_asistencia = $this->fecha_asistencia;
        $hora_inicio = Carbon::createFromFormat('H:i', $this->hora_inicio_asistencia);
        $asistencia->hora_inicio_asistencia = $hora_inicio->format('H:i:s');
        $hora_fin = Carbon::createFromFormat('H:i', $this->hora_fin_asistencia);
        $asistencia->hora_fin_asistencia = $hora_fin->format('H:i:s');
        $asistencia->id_tipo_asistencia = $this->tipo_asistencia;
        $asistencia->save();
    }


    /**
     * Validar hora de inicio
     */
    public function validate_hora_inicio()
    {
        $horaActual = Carbon::now()->format('H:i');
        $fechaActual = Carbon::today()->toDateString();

        if ($this->fecha_asistencia == $fechaActual && $this->hora_inicio_asistencia < $horaActual) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Validar fecha
     */
    public function validate_fecha()
    {
        $fechaActual = Carbon::today()->toDateString();

        if ($this->fecha_asistencia < $fechaActual) {
            return true;
        }

        return false;
    }


    /**
     * Abrir modal para eliminar asistencia
     */
    public function abrir_modal_eliminar(Asistencia $asistencia)
    {
        $this->id_asistencia_a_eliminar = $asistencia->id_asistencia;
        $this->tipo_asistencia_a_eliminar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
        $this->fecha_asistencia_a_eliminar = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia_a_eliminar = format_hora($asistencia->hora_inicio_asistencia);
        $this->hora_fin_asistencia_a_eliminar = format_hora($asistencia->hora_fin_asistencia);
    }


    /**
     * Eliminar asistencia
     */
    public function eliminar_asistencia(Asistencia $asistencia)
    {
        try {
            DB::beginTransaction();

            if ($asistencia->asistenciaAlumno()->count() > 0) {
                $asistencia->asistenciaAlumno()->delete();
            }
            $asistencia->delete();

            DB::commit();

            $this->cerrar_modal('#modal-eliminar');
            $this->limpiar_modal_eliminar();

            $this->dispatch(
                'toast-basico',
                mensaje: 'La asistencia se ha eliminado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al eliminar la asistencia.',
                type: 'error'
            );
        }
    }


    /**
     * Limpiar modal de eliminar
     */
    public function limpiar_modal_eliminar()
    {
        $this->id_asistencia_a_eliminar = null;
        $this->tipo_asistencia_a_eliminar = '';
        $this->fecha_asistencia_a_eliminar = '';
        $this->hora_inicio_asistencia_a_eliminar = '';
        $this->hora_fin_asistencia_a_eliminar = '';
    }


    /**
     * Abrir modal para enviar asistencia
     */
    public function abrir_modal_enviar_asistencia(Asistencia $asistencia)
    {
        $this->limpiar_modal_enviar();

        $this->id_asistencia_enviar = $asistencia->id_asistencia;
        $this->estados = EstadoAsistencia::estado(true)->get();
        $this->tipo_asistencia_a_enviar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
        $this->fecha_asistencia_a_enviar = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia_a_enviar = $asistencia->hora_inicio_asistencia;
        $this->hora_fin_asistencia_a_enviar = $asistencia->hora_fin_asistencia;
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

            if (verificar_hora_actual($this->hora_inicio_asistencia_a_enviar, $this->hora_fin_asistencia_a_enviar, $this->fecha_asistencia_a_enviar)) {
                $asistencia_alumno = new AsistenciaAlumno();
                $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                $asistencia_alumno->id_gestion_aula_alumno = $this->id_gestion_aula_alumno;
                $asistencia_alumno->save();
            } else {
                $this->cerrar_modal('#modal-enviar-asistencia');
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se puede enviar la asistencia,  el horario permitido para marcar asistencia ha finalizado.',
                    type: 'error'
                );
                return;
            }

            DB::commit();

            $this->cerrar_modal('#modal-enviar-asistencia');
            $this->limpiar_modal_enviar();

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
                mensaje: 'Ha ocurrido un error al enviar la asistencia.',
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
     * Cerrar modal de asistencias
     */
    public function limpiar_modal()
    {
        $this->modo_asistencias = 1;
        $this->titulo_asistencias = 'Agregar Asistencia';
        $this->accion_asistencias = 'Agregar';
        $this->tipo_asistencia = '';
        $this->fecha_asistencia = '';
        $this->fecha_asistencia_temporal = '';
        $this->hora_inicio_asistencia = '';
        $this->hora_fin_asistencia = '';
        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Limpiar modal de enviar asistencia
     */
    public function limpiar_modal_enviar()
    {
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
     * Redirigir a la vista de detalle de asistencias
     */
    public function redirifir_detalle_asistencias(Asistencia $asistencia)
    {
        $this->redirect(route('carga-academica.detalle.asistencia.detalle', [
            'id_usuario' => $this->id_usuario_hash,
            'tipo_vista' => $this->tipo_vista,
            'id_curso' => $this->id_gestion_aula_hash,
            'id_asistencia' => Hashids::encode($asistencia->id_asistencia)
        ]));
    }


    /**
     * Obtener datos para el page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Asistencia';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];

        // Links --> Cursos o Carga Académica
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Mis Cursos',
                'route' => 'cursos',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Carga Académica',
                'route' => 'carga-academica',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
            ];
        }

        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => $gestion_aula->curso->nombre_curso,
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => $gestion_aula->curso->nombre_curso,
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }
    }


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');

        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->obtener_datos_page_header();

        if ($this->tipo_vista === 'cursos') {
            $this->id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
                ->gestionAula($this->id_gestion_aula)
                ->estado(true)
                ->first()
                ->id_gestion_aula_alumno ?? null;
        } else {
            $this->id_gestion_aula_docente = GestionAulaDocente::where('id_usuario', $this->usuario->id_usuario)
                ->gestionAula($this->id_gestion_aula)
                ->estado(true)
                ->first()
                ->id_gestion_aula_docente ?? null;
        }
    }


    public function render()
    {
        if ($this->tipo_vista === 'cursos') {
            $asistencias = Asistencia::with([
                'asistenciaAlumno' => function ($query) {
                    $query->with([
                        'estadoAsistencia',
                        'gestionAulaAlumno'
                    ])->where('id_gestion_aula_alumno', $this->id_gestion_aula_alumno);
                },
                'tipoAsistencia'
            ])->gestionAula($this->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'asc')
                ->orderBy('hora_inicio_asistencia', 'asc')
                ->paginate($this->mostrar_paginate);

        } elseif ($this->tipo_vista === 'carga-academica') {
            $asistencias = Asistencia::with([
                'tipoAsistencia',
            ])
                ->gestionAula($this->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'asc')
                ->orderBy('hora_inicio_asistencia', 'asc')
                ->paginate($this->mostrar_paginate);
        }

        $tipo_asistencias = TipoAsistencia::estado(true)->get();

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => $asistencias,
            'tipo_asistencias' => $tipo_asistencias
        ]);
    }
}
