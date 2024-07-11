<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\GestionAulaUsuario;
use App\Models\TipoAsistencia;
use App\Models\Usuario;
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

    // Variables para el modal de Asistencias
    public $modo_asistencias = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_asistencias = 'Agregar Link de Clase';
    public $accion_asistencias = 'Agregar';
    #[Validate('required')]
    public $tipo_asistencia;
    #[Validate('required|date|after_or_equal:today')]
    public $fecha_asistencia;
    #[Validate('required|date_format:H:i')]
    public $hora_inicio_asistencia;
    #[Validate('required|date_format:H:i')]
    public $hora_fin_asistencia;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    protected $messages = [
        'fecha_asistencia.after_or_equal' => 'El campo fecha de asistencia debe ser una fecha posterior o igual a hoy.',
    ];


    public function updatingMostrarPaginate()
    {
        $this->resetPage();
    }


    /* =============== FUNCIONES PARA EL MODAL DE LINK DE CURSO Y ORIENTACIONES - AGREGAR Y EDITAR =============== */
    public function abrir_modal_asistencias_agregar()
    {
        // $this->limpiar_modal();

        $this->modo_asistencias = 1; // Agregar
        $this->titulo_asistencias = 'Agregar Asistencia';
        $this->accion_asistencias = 'Agregar';

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
            'hora_fin_asistencia' => 'required|date_format:H:i',
        ]);
        dd($this->fecha_asistencia, $this->hora_inicio_asistencia, $this->hora_fin_asistencia);
    }


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


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);
        if (session('modo_admin') || $usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }else{
            session()->forget('modo_admin');
        }

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
                            $query->where('id_usuario', $this->usuario->id_usuario)
                                ->select('id_gestion_aula_usuario', 'id_gestion_aula', 'id_usuario');
                        }
                    ])->select('id_asistencia_alumno', 'id_estado_asistencia', 'id_asistencia', 'id_gestion_aula_usuario');
                },
                'tipoAsistencia' => function ($query) {
                    $query->select('id_tipo_asistencia', 'nombre_tipo_asistencia');
                }
            ])->where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'desc')
                ->orderBy('hora_inicio_asistencia', 'desc')
                ->paginate($this->mostrar_paginate);

        }elseif($this->tipo_vista === 'carga-academica')
        {
            $asistencias = Asistencia::where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'desc')
                ->orderBy('hora_inicio_asistencia', 'desc')
                ->paginate($this->mostrar_paginate);
        }

        $tipo_asistencias = TipoAsistencia::where('estado_tipo_asistencia', 1)->get();

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => $asistencias,
            'tipo_asistencias' => $tipo_asistencias
        ]);
    }
}
