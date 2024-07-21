<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\AsistenciaAlumno;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
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


     /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Detalle de Asistencia';

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
                    }
                ])->where('id_asistencia', $this->id_asistencia);
            }
        ])->where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->paginate($this->mostrar_paginate);


        // $alumnos = AsistenciaAlumno::where('id_asistencia', $this->id_asistencia)
        //     ->paginate($this->mostrar_paginate);
        return view('livewire.gestion-aula.asistencia.detalle', [
            'alumnos' => $alumnos
        ]);
    }
}
