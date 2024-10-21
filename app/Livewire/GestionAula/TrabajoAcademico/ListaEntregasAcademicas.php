<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\TrabajoAcademico;
use App\Traits\UsuarioTrait;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class ListaEntregasAcademicas extends Component
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
    public $trabajo_academico;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Lista de entregas académicas';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Obtener datos para mostrar el componente page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Lista de entregas académicas';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle.trabajo-academico.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle.trabajo-academico.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
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

        // Links --> Trabajos académicos
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Trabajos académicos',
                'route' => 'cursos.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Trabajos académicos',
                'route' => 'carga-academica.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }

        // Links --> Lista de Detalle de trabajo académico
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Detalle del trabajo académico',
                'route' => 'cursos.detalle.trabajo-academico.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Detalle del trabajo académico',
                'route' => 'carga-academica.detalle.trabajo-academico.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
            ];
        }
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_trabajo_academico)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $id_trabajo_academico = Hashids::decode($id_trabajo_academico);
        $this->trabajo_academico = TrabajoAcademico::with('archivoDocente')->find($id_trabajo_academico[0]);

        $this->obtener_datos_page_header();
    }


    public function render()
    {
        $entregas_academicas = GestionAulaAlumno::with([
            'usuario' => function ($query) {
                $query->with('persona');
            },
            'trabajoAcademicoAlumno' => function ($query) {
                $query->with('estadoTrabajoAcademico', 'archivoAlumno', 'comentarioTrabajoAcademico')
                    ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
                    ->first();
            }
        ])->gestionAula($this->id_gestion_aula)
            ->whereHas('usuario', function ($query) {
                $query->estado(true);
            })
            ->searchAlumno($this->search)
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.trabajo-academico.lista-entregas-academicas', [
            'entregas_academicas' => $entregas_academicas
        ]);
    }
}
