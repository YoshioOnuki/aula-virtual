<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\AsistenciaAlumno;
use App\Models\EstadoAsistencia;
use App\Models\GestionAula;
use App\Models\GestionAulaUsuario;
use App\Models\TipoAsistencia;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;

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

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    protected $messages = [
        'tipo_asistencia.required' => 'El campo tipo de asistencia es obligatorio.',
        'fecha_asistencia.after_or_equal' => 'El campo fecha de asistencia debe ser una fecha posterior o igual a hoy.',
        'hora_fin_asistencia.after' => 'El campo hora de fin debe ser una hora posterior a la hora de inicio.',
    ];


    public function updatingMostrarPaginate()
    {
        $this->resetPage();
    }


    /* =============== FUNCIONES PARA EL MODAL DE ASISTENCIA- AGREGAR Y EDITAR =============== */
        public function abrir_modal_asistencias_agregar()
        {
            $this->limpiar_modal();

            $this->modo_asistencias = 1; // Agregar
            $this->titulo_asistencias = 'Agregar Asistencia';
            $this->accion_asistencias = 'Agregar';

            $this->dispatch(
                'modal',
                modal: '#modal-asistencias',
                action: 'show'
            );
        }

        public function abrir_modal_asistencias_editar(Asistencia $asistencia)
        {
            $this->limpiar_modal();

            $this->modo_asistencias = 0; // Editar
            $this->titulo_asistencias = 'Editar Asistencia';
            $this->accion_asistencias = 'Editar';

            $this->id_asistencia_editar = $asistencia->id_asistencia;
            $this->tipo_asistencia = $asistencia->id_tipo_asistencia;
            $this->fecha_asistencia = $asistencia->fecha_asistencia;
            $this->fecha_asistencia_temporal = $this->fecha_asistencia;
            $this->hora_inicio_asistencia = Carbon::createFromFormat('H:i:s', $asistencia->hora_inicio_asistencia)->format('H:i');
            $this->hora_fin_asistencia = Carbon::createFromFormat('H:i:s', $asistencia->hora_fin_asistencia)->format('H:i');

            $this->dispatch(
                'modal',
                modal: '#modal-asistencias',
                action: 'show'
            );
        }

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
            }else{
                try
                {
                    DB::beginTransaction();

                    if ($this->modo_asistencias == 1) // Agregar
                    {
                        $this->agregar_asistenca();
                    }else{
                        $this->editar_asistencia();
                    }

                    DB::commit();

                    $this->cerrar_modal();

                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'La asistencia se ha guardado correctamente',
                        type: 'success'
                    );

                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'Ha ocurrido un error al guardar la asistencia: ',
                        type: 'error'
                    );
                }
            }
        }

        public function agregar_asistenca()
        {
            $id_gestion_aula = GestionAulaUsuario::where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first()->id_gestion_aula;
            $asistencia = new Asistencia();
            $asistencia->fecha_asistencia = $this->fecha_asistencia;
            $hora_inicio = Carbon::createFromFormat('H:i', $this->hora_inicio_asistencia);
            $asistencia->hora_inicio_asistencia = $hora_inicio->format('H:i:s');
            $hora_fin = Carbon::createFromFormat('H:i', $this->hora_fin_asistencia);
            $asistencia->hora_fin_asistencia = $hora_fin->format('H:i:s');
            $asistencia->id_tipo_asistencia = $this->tipo_asistencia;
            $asistencia->id_gestion_aula = $id_gestion_aula;
            $asistencia->save();
        }

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

        public function validate_hora_inicio()
        {
            $horaActual = Carbon::now()->format('H:i');
            $fechaActual = Carbon::today()->toDateString();

            if ($this->fecha_asistencia == $fechaActual && $this->hora_inicio_asistencia < $horaActual) {
                return true;
            }else{
                return false;
            }
        }

        public function validate_fecha()
        {
            $fechaActual = Carbon::today()->toDateString();

            if ($this->fecha_asistencia < $fechaActual) {
                return true;
            }

            return false;
        }

        public function cerrar_modal()
        {
            $this->limpiar_modal();
            $this->dispatch(
                'modal',
                modal: '#modal-asistencias',
                action: 'hide'
            );
        }

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
    /* ========================================================================================================== */



    /* =============== FUNCIONES PARA EL MODAL DE ELIMINAR ASISTENCIA =============== */
        public function abrir_modal_eliminar(Asistencia $asistencia)
        {
            $this->dispatch(
                'modal',
                modal: '#modal-eliminar',
                action: 'show'
            );

            $this->id_asistencia_a_eliminar = $asistencia->id_asistencia;
            $this->tipo_asistencia_a_eliminar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
            $this->fecha_asistencia_a_eliminar = $asistencia->fecha_asistencia;
            $this->hora_inicio_asistencia_a_eliminar = format_hora($asistencia->hora_inicio_asistencia);
            $this->hora_fin_asistencia_a_eliminar = format_hora($asistencia->hora_fin_asistencia);
        }

        public function eliminar_asistencia(Asistencia $asistencia)
        {
            try
            {
                DB::beginTransaction();

                $asistencia->asistenciaAlumno()->delete();
                $asistencia->delete();

                DB::commit();

                $this->cerrar_modal_eliminar();

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

        public function cerrar_modal_eliminar()
        {
            $this->id_asistencia_a_eliminar = null;
            $this->tipo_asistencia_a_eliminar = '';
            $this->fecha_asistencia_a_eliminar = '';
            $this->hora_inicio_asistencia_a_eliminar = '';
            $this->hora_fin_asistencia_a_eliminar = '';

            $this->dispatch(
                'modal',
                modal: '#modal-eliminar',
                action: 'hide'
            );
        }
    /* ============================================================================== */



    /* =============== FUNCIONES PARA EL MODAL DE  ENVIAR ASISTENCIAS =============== */
        public function abrir_modal_enviar_asistencia(Asistencia $asistencia)
        {
            $this->limpiar_modal_enviar();
            $this->dispatch(
                'modal',
                modal: '#modal-enviar-asistencia',
                action: 'show'
            );

            $this->id_asistencia_enviar = $asistencia->id_asistencia;
            $this->estados = EstadoAsistencia::where('estado_estado_asistencia', 1)->get();
            $this->tipo_asistencia_a_enviar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
            $this->fecha_asistencia_a_enviar = $asistencia->fecha_asistencia;
            $this->hora_inicio_asistencia_a_enviar = $asistencia->hora_inicio_asistencia;
            $this->hora_fin_asistencia_a_enviar = $asistencia->hora_fin_asistencia;
        }

        public function enviar_asistencia()
        {
            $this->validate([
                'estado_asistencia' => 'required'
            ]);

            try
            {
                DB::beginTransaction();

                // dd(verificar_hora_actual($this->hora_inicio_asistencia_a_enviar, $this->hora_fin_asistencia_a_enviar, $this->fecha_asistencia_a_enviar));
                if(verificar_hora_actual($this->hora_inicio_asistencia_a_enviar, $this->hora_fin_asistencia_a_enviar, $this->fecha_asistencia_a_enviar))
                {
                    $asistencia_alumno = new AsistenciaAlumno();
                    $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                    $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                    $asistencia_alumno->id_gestion_aula_usuario = $this->id_gestion_aula_usuario;
                    $asistencia_alumno->save();
                }else{
                    $this->cerrar_modal_enviar();
                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'No se puede enviar la asistencia,  el horario permitido para marcar asistencia ha finalizado.',
                        type: 'error'
                    );
                    return;
                }

                DB::commit();

                $this->cerrar_modal_enviar();

                $this->dispatch(
                    'toast-basico',
                    mensaje: 'La asistencia se ha enviado correctamente',
                    type: 'success'
                );

            } catch (\Exception $e) {
                DB::rollBack();
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Ha ocurrido un error al enviar la asistencia.',
                    type: 'error'
                );
            }
        }

        public function cerrar_modal_enviar()
        {
            $this->limpiar_modal_enviar();
            $this->dispatch(
                'modal',
                modal: '#modal-enviar-asistencia',
                action: 'hide'
            );
        }

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
    /* ============================================================================== */



    /* =============== OBTENER DATOS PARA REDIRIJIR =============== */
        public function redirifir_detalle_asistencias(Asistencia $asistencia)
        {
            $this->redirect(route('carga-academica.detalle.asistencia.detalle', [
                'id_usuario' => $this->id_usuario_hash,
                'tipo_vista' => $this->tipo_vista,
                'id_curso' => $this->id_gestion_aula_usuario_hash,
                'id_asistencia' => Hashids::encode($asistencia->id_asistencia)
            ]));
        }
    /* ============================================================ */


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_page_header = 'Asistencia';

            // Regresar
            if($this->tipo_vista === 'cursos')
            {
                $this->regresar_page_header = [
                    'route' => 'cursos.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->regresar_page_header = [
                    'route' => 'carga-academica.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
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
            if ($this->tipo_vista === 'cursos')
            {
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

            // Links --> Detalle del curso o carga académica
            if ($this->tipo_vista === 'cursos')
            {
                $this->links_page_header[] = [
                    'name' => 'Detalle',
                    'route' => 'cursos.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Detalle',
                    'route' => 'carga-academica.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            }

        }
    /* ==================================================================================== */



    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $user = Auth::user();
        $usuario_sesion = Usuario::find($user->id_usuario);
        if ($usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }

        $this->es_docente = $this->usuario->esRolGestionAula('DOCENTE', $this->id_gestion_aula_usuario);
        $this->es_docente_invitado = $this->usuario->esRolGestionAula('DOCENTE INVITADO', $this->id_gestion_aula_usuario);

        $this->obtener_datos_page_header();

    }

    public function render()
    {

        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->select('id_gestion_aula');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if($this->tipo_vista === 'cursos')
        {
            $asistencias = Asistencia::with([
                'asistenciaAlumno' => function ($query) {
                    $query->with([
                        'estadoAsistencia' => function ($query) {
                            $query->select('id_estado_asistencia', 'nombre_estado_asistencia');
                        },
                        'gestionAulaUsuario' => function ($query) {
                            $query->select('id_gestion_aula_usuario', 'id_gestion_aula', 'id_usuario');
                        }
                    ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
                        ->select('id_asistencia_alumno', 'id_estado_asistencia', 'id_asistencia', 'id_gestion_aula_usuario');
                },
                'tipoAsistencia' => function ($query) {
                    $query->select('id_tipo_asistencia', 'nombre_tipo_asistencia');
                }
            ])->where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'asc')
                ->orderBy('hora_inicio_asistencia', 'asc')
                ->paginate($this->mostrar_paginate);

            // dd($asistencias);

        }elseif($this->tipo_vista === 'carga-academica')
        {
            $asistencias = Asistencia::where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'asc')
                ->orderBy('hora_inicio_asistencia', 'asc')
                ->paginate($this->mostrar_paginate);
        }

        $tipo_asistencias = TipoAsistencia::where('estado_tipo_asistencia', 1)->get();

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => $asistencias,
            'tipo_asistencias' => $tipo_asistencias
        ]);
    }
}
