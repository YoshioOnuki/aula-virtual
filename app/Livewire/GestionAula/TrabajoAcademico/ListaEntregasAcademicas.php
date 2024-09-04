<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class ListaEntregasAcademicas extends Component
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
    public $trabajo_academico;


    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Lista de entregas académicas';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_page_header = 'Lista de entregas académicas';

            // Regresar
            if ($this->tipo_vista === 'cursos') {
                $this->regresar_page_header = [
                    'route' => 'cursos.detalle.trabajo-academico.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
                ];
            } else {
                $this->regresar_page_header = [
                    'route' => 'carga-academica.detalle.trabajo-academico.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
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

            // Links --> Detalle del curso o carga académica
            if ($this->tipo_vista === 'cursos') {
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

            // Links --> Trabajos académicos
            if ($this->tipo_vista === 'cursos') {
                $this->links_page_header[] = [
                    'name' => 'Trabajos académicos',
                    'route' => 'cursos.detalle.trabajo-academico',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Trabajos académicos',
                    'route' => 'carga-academica.detalle.trabajo-academico',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            }

            // Links --> Lista de Detalles de trabajos académicos
            if ($this->tipo_vista === 'cursos') {
                $this->links_page_header[] = [
                    'name' => 'Lista de detalles de trabajos académicos',
                    'route' => 'cursos.detalle.trabajo-academico.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Lista de detalles de trabajos académicos',
                    'route' => 'carga-academica.detalle.trabajo-academico.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
                ];
            }
        }
    /* ==================================================================================== */


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_trabajo_academico)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_trabajo_academico = Hashids::decode($id_trabajo_academico);
        $this->trabajo_academico = TrabajoAcademico::with('archivoDocente')->find($id_trabajo_academico[0]);
        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $user = Auth::user();
        $usuario_sesion = Usuario::find($user->id_usuario);

        if ($usuario_sesion->esRol('ADMINISTRADOR')) {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();
    }


    public function render()
    {

        $entregas_academicas = GestionAulaUsuario::with([
            'usuario' => function ($query) {
                $query->with('persona');
            },
            'trabajoAcademicoAlumno' => function ($query) {
                $query->with('estadoTrabajoAcademico', 'archivoAlumno', 'comentarioTrabajoAcademico')
                    ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                    ->first();
            },
            'rol' => function ($query) {
                $query->where('estado_rol', 1);
            }
        ])->where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('usuario', function ($query) {
                $query->where('estado_usuario', 1);
            })
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->searchAlumno($this->search)
            ->paginate($this->mostrar_paginate);


        return view('livewire.gestion-aula.trabajo-academico.lista-entregas-academicas',[
            'entregas_academicas' => $entregas_academicas
        ]);
    }
}
