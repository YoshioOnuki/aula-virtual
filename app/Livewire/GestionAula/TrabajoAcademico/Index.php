<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;
    public $trabajos_academicos;

    // Variables para la carga de datos
    public $cargando_trabajos = true;

    // Variables para el modal de Trabajo Académico
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Trabajo Académico';
    public $accion_modal = 'Agregar';
    #[Validate('required')]
    public $nombre_trabajo_academico;
    #[Validate('nullable')]
    public $descripcion_trabajo_academico;
    #[Validate('required')]
    public $fecha_inicio_trabajo_academico;
    #[Validate('required')]
    public $fecha_fin_trabajo_academico;
    #[Validate('required')]
    public $hora_inicio_trabajo_academico;
    #[Validate('required')]
    public $hora_fin_trabajo_academico;


    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    /* =============== FUNCIONES PARA EL MODAL DE TRABAJO ACADEMICO - AGREGAR =============== */
        public function abrir_modal_trabajo()
        {
            // $this->limpiar_modal();

            $this->modo = 1;
            $this->titulo_modal = 'Agregar Trabajo Académico';
            $this->accion_modal = 'Agregar';

            $this->dispatch(
                'modal',
                modal: '#modal-trabajo-academico',
                action: 'show'
            );

        }
    /* ====================================================================================== */


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_page_header = 'Trabajos Académicos';

            // Regresar
            if ($this->tipo_vista === 'cursos') {
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
        }
    /* ==================================================================================== */


    /* =============== OBTENER DATOS PARA MOSTRAR LOS RECURSOS =============== */
        public function mostrar_trabajos()
        {
            $this->gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'curso' => function ($query) {
                            $query->with([
                                'ciclo',
                                'planEstudio',
                                'programa' => function ($query) {
                                    $query->with([
                                        'facultad',
                                        'tipoPrograma'
                                    ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                                }
                            ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
                        },
                        'trabajoAcademico' => function ($query) {
                            $query->with([
                                'archivoDocente' => function ($query) {
                                    $query->get();
                                },
                                'trabajoAcademicoAlumno' => function ($query) {
                                    $query->with([
                                        'archivoAlumno' => function ($query) {
                                            $query->get();
                                        },
                                        'estadoTrabajoAcademico' => function ($query) {
                                            $query->first();
                                        },
                                        'comentarioTrabajoAcademico' => function ($query) {
                                            $query->get();
                                        }
                                    ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->get();
                                },
                            ])->orderBy('fecha_inicio_trabajo_academico', 'DESC')
                                ->get();
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
                ->first();

            if ($this->gestion_aula_usuario) {
                $this->trabajos_academicos = $this->gestion_aula_usuario->gestionAula->trabajoAcademico;
            }
        }

        public function load_trabajos()
        {
            $this->mostrar_trabajos();
            $this->cargando_trabajos = false;
        }

    /* ======================================================================= */


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
        public function load_trabajos_llamar()
        {
            $this->dispatch('load_trabajos_evento');
        }
    /* ======================================================================================= */


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        // $this->calcular_cantidad_recursos();

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);

        if ($usuario_sesion->esRol('ADMINISTRADOR')) {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();
    }

    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.index');
    }
}
