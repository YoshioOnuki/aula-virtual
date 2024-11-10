<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\GestionAulaDocente;
use App\Models\TrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use App\Traits\UsuarioTrait;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]

class EntregaAcademica extends Component
{
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $trabajo_academico;
    public $trabajo_academico_alumno;
    public $gestion_aula_alumno;
    public $id_gestion_aula_alumno;
    public $id_gestion_aula_docente;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Lista de entregas académicas';
    public $links_page_header = [];
    public $regresar_page_header;


    // Listener para actualizar la vista actualizar_estado_entrega
    protected $listeners = [
        'actualizar_estado_entrega' => 'actualizar_estado_entrega',
        'permiso_denegado' => 'permiso_denegado'
    ];


    /**
     * Evento para actualizar el estado de la entrega académica
     */
    public function actualizar_estado_entrega()
    {
        $this->dispatch('actualizar_estado_entrega_alumno');
    }


    /**
     * Evento para mostrar un mensaje de permiso denegado
     */
    public function permiso_denegado()
    {
        $this->dispatch(
            'toast-basico',
            mensaje: 'Usted no tiene permisos para realizar esta acción',
            type: 'error'
        );
    }


    /**
     * Obtener datos para mostrar el componente page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Entrega Académica';

        // Regresar
        $this->regresar_page_header = [
            'route' => 'carga-academica.detalle.trabajo-academico.alumnos',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
        ];

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

        // Links --> Lista de entregas académicas

        $this->links_page_header[] = [
            'name' => 'Lista de entregas académicas',
            'route' => 'carga-academica.detalle.trabajo-academico.alumnos',
            'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_trabajo_academico' => Hashids::encode($this->trabajo_academico->id_trabajo_academico)]
        ];
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_trabajo_academico, $id_trabajo_academico_alumno)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $id_trabajo_academico = Hashids::decode($id_trabajo_academico);
        $this->trabajo_academico = TrabajoAcademico::find($id_trabajo_academico[0]);

        $id_trabajo_academico_alumno = Hashids::decode($id_trabajo_academico_alumno);
        $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::with([
            'trabajoAcademico',
            'estadoTrabajoAcademico',
            'comentarioTrabajoAcademico'
        ])->find($id_trabajo_academico_alumno[0]);

        $this->id_gestion_aula_docente = GestionAulaDocente::where('id_usuario', $this->usuario->id_usuario)
            ->gestionAula($this->id_gestion_aula)
            ->first()
            ->id_gestion_aula_docente;

        $this->gestion_aula_alumno = GestionAulaAlumno::with([
            'usuario'
        ])->find($this->trabajo_academico_alumno->id_gestion_aula_alumno);
        $this->id_gestion_aula_alumno = $this->gestion_aula_alumno->id_gestion_aula_alumno;

        $this->obtener_datos_page_header();
    }


    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.entrega-academica');
    }
}
