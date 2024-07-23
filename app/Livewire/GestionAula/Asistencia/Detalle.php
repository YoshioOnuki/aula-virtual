<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\AsistenciaAlumno;
use App\Models\EstadoAsistencia;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class Detalle extends Component
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
    public $id_gestion_aula_usuario_enviar;

    public $check_alumno = [];
    public $check_all = false;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;


    /* =============== FUNCION UPDATE PARA CHECKBOX =============== */
    public function updatedCheckAll($value)
    {
        $alumnos = GestionAulaUsuario::where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            // que no tenga registros en la tabla asistencia_alumno
            ->whereDoesntHave('asistenciaAlumno', function ($query) {
                $query->where('id_asistencia', $this->id_asistencia);
            })
            ->get();
        if ($value)
        {
            // Marcar todos los checks true
            foreach ($alumnos as $alumno)
            {
                $this->check_alumno[$alumno->id_gestion_aula_usuario] = true;
            }
        } else {
            // Desmarcar todos los checks false
            foreach ($alumnos as $alumno)
            {
                $this->check_alumno[$alumno->id_gestion_aula_usuario] = false;
            }
        }
    }

    /* =============== FUNCIONES PARA EL MODAL DE  ENVIAR ASISTENCIAS =============== */
    public function abrir_modal_enviar_asistencia($id_gestion_aula_usuario)
    {
        $this->limpiar_modal_enviar();
        $this->dispatch(
            'modal',
            modal: '#modal-enviar-asistencia',
            action: 'show'
        );

        $this->titulo_modal_enviar = 'Enviar Asistencia';
        $this->modo_enviar = 0; // Enviar asistencia a un solo alumno

        $this->id_gestion_aula_usuario_enviar = $id_gestion_aula_usuario;
        $this->id_asistencia_enviar = $this->id_asistencia;
        $asistencia = Asistencia::find($this->id_asistencia);

        $this->estados = EstadoAsistencia::where('estado_estado_asistencia', 1)->get();
        $this->tipo_asistencia_a_enviar = $asistencia->tipoAsistencia->nombre_tipo_asistencia;
        $this->fecha_asistencia_a_enviar = $asistencia->fecha_asistencia;
        $this->hora_inicio_asistencia_a_enviar = $asistencia->hora_inicio_asistencia;
        $this->hora_fin_asistencia_a_enviar = $asistencia->hora_fin_asistencia;
    }

    public function abrir_modal_enviar_asistencias()
    {
        $this->limpiar_modal_enviar();
        $this->dispatch(
            'modal',
            modal: '#modal-enviar-asistencia',
            action: 'show'
        );

        $this->titulo_modal_enviar = 'Enviar varias asistencias';
        $this->modo_enviar = 1; // Enviar asistencia a varios alumnos

        $this->id_asistencia_enviar = $this->id_asistencia;
        $asistencia = Asistencia::find($this->id_asistencia);

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

            if(count($this->check_alumno) > 0 && $this->modo_enviar === 1)
            {
                // Eliminar los checks falsos
                $this->check_alumno = array_filter($this->check_alumno);
                // Sacar los alumnos seleccionados por sus indices
                $this->check_alumno = array_keys($this->check_alumno);
                foreach ($this->check_alumno as $id_gestion_aula_usuario)
                {
                    $asistencia_alumno = new AsistenciaAlumno();
                    $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                    $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                    $asistencia_alumno->id_gestion_aula_usuario = $id_gestion_aula_usuario;
                    $asistencia_alumno->save();
                }
            } else if ($this->modo_enviar === 1 && count($this->check_alumno) <= 0){
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se ha seleccionado ningún alumno.',
                    type: 'error'
                );
                return;
            } else {
                $asistencia_alumno = new AsistenciaAlumno();
                $asistencia_alumno->id_asistencia = $this->id_asistencia_enviar;
                $asistencia_alumno->id_estado_asistencia = $this->estado_asistencia;
                $asistencia_alumno->id_gestion_aula_usuario = $this->id_gestion_aula_usuario_enviar;
                $asistencia_alumno->save();
            }

            // Limpiar los checks
            $this->check_alumno = [];
            $this->check_all = false;


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
                mensaje: 'Ha ocurrido un error al enviar la asistencia.' . $e->getMessage(),
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


     /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Detalle de Asistencia';

        // Regresar
        if($this->tipo_vista === 'cursos')
        {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle.asistencia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle.asistencia',
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

        // Links --> Asistencia
        if ($this->tipo_vista === 'cursos')
        {
            $this->links_page_header[] = [
                'name' => 'Asistencia',
                'route' => 'cursos.detalle.asistencia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Asistencia',
                'route' => 'carga-academica.detalle.asistencia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        }

    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_asistencia)
    {
        $this->id_asistencia = Hashids::decode($id_asistencia);
        $this->id_asistencia = $this->id_asistencia[0];

        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];
        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;


        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);
        if ($usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();

        $alumnos = GestionAulaUsuario::where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->whereDoesntHave('asistenciaAlumno', function ($query) {
                $query->where('id_asistencia', $this->id_asistencia);
            })
            ->get();

        foreach ($alumnos as $alumno)
        {
            $this->check_alumno[$alumno->id_gestion_aula_usuario] = false;
        }

        $this->check_all = false;
    }


    public function render()
    {
        $alumnos = GestionAulaUsuario::with([
            'usuario' => function ($query) {
                $query->with([
                    'persona' => function ($query) {
                        $query->select('id_persona', 'documento_persona', 'nombres_persona', 'apellido_paterno_persona', 'apellido_materno_persona', 'codigo_alumno_persona', 'correo_persona');
                    }
                ])->select('id_usuario', 'correo_usuario', 'foto_usuario', 'estado_usuario', 'id_persona');
            },
            'rol' => function ($query) {
                $query->select('id_rol', 'nombre_rol', 'estado_rol');
            },
            'asistenciaAlumno' => function ($query) {
                $query->with([
                    'estadoAsistencia' => function ($query) {
                        $query->select('id_estado_asistencia', 'nombre_estado_asistencia');
                    },
                    'asistencia' => function ($query) {
                        $query->select('id_asistencia', 'fecha_asistencia', 'hora_inicio_asistencia', 'hora_fin_asistencia');
                    }
                ])->where('id_asistencia', $this->id_asistencia);
            }
        ])->join('usuario', 'usuario.id_usuario', '=', 'gestion_aula_usuario.id_usuario')
            ->join('persona', 'persona.id_persona', '=', 'usuario.id_persona')
            ->where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->orderBy('persona.nombres_persona')
            ->orderBy('persona.apellido_paterno_persona')
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.asistencia.detalle', [
            'alumnos' => $alumnos
        ]);
    }
}
