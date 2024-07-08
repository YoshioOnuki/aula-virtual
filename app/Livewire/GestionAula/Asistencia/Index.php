<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
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

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Asistencia';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    public function updatingMostrarPaginate()
    {
        $this->resetPage();
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

        if (session('modo_admin'))
        {
            $this->modo_admin = session('modo_admin');
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

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => $asistencias,
        ]);
    }
}
