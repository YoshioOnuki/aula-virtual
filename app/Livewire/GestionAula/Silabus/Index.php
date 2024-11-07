<?php

namespace App\Livewire\GestionAula\Silabus;

use App\Models\GestionAula;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;
    use UsuarioTrait;

    public $usuario;
    public $id_usuario_hash;
    public $gestion_aula;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $curso;
    public $silabus_pdf;// Variable para mostrar el silabus

    // Variables para subir el silabus
    #[Validate('required|file|mimes:pdf|max:4096')]
    public $silabus;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para carga de datos
    public $cargando_datos_curso = false;
    public $cargando_silabus = false;

    // Variables para page-header
    public $titulo_page_header = 'Silabus';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Métodos para subir y guardar el silabus
     */
    public function subir_silabus()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula);

        $archivo = $this->silabus;
        $nombre_silabus_antiguo = $this->silabus_pdf->archivo_silabus ?? null;
        array_push($carpetas, 'silabus');
        $extencion_archivo = 'pdf';
        $nombre_bd = subir_archivo($archivo, $nombre_silabus_antiguo, $carpetas, $extencion_archivo);

        return $nombre_bd;
    }


    /**
     * Guardar el silabus
     */
    public function guardar_silabus()
    {
        $this->validate();


        try
        {
            DB::beginTransaction();

            $nombre_bd = $this->subir_silabus();

            $gestion_aula = GestionAula::with('silabus')
                ->find($this->id_gestion_aula);

            if ($gestion_aula) {
                $gestion_aula->silabus()->updateOrCreate(
                    ['id_gestion_aula' => $gestion_aula->id_gestion_aula],
                    ['archivo_silabus' => $nombre_bd]
                );
            }

            DB::commit();

            $this->mostrar_silabus();
            $this->reset('silabus');

            $this->dispatch(
                'toast-basico',
                mensaje: 'El silabus se ha guardado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el silabus: '.$e->getMessage(),
                type: 'error'
            );
        }

    }


    /**
     * Mostrar datos del curso y silabus
     */
    public function mostrar_datos_curso()
    {
        $this->gestion_aula = GestionAula::with([
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
            }
        ])->find($this->id_gestion_aula);

        if ($this->gestion_aula) {
            $this->curso = $this->gestion_aula->curso;
        }
    }


    /**
     * Mostrar silabus
     */
    public function mostrar_silabus()
    {
        $gestion_aula = GestionAula::with('silabus')->find($this->id_gestion_aula);
        $this->silabus_pdf = $gestion_aula->silabus ?? null;
    }


    /**
     * Obtener datos para el page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Silabus';

        // Regresar
        if($this->tipo_vista === 'cursos')
        {
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
                'name' => $this->curso->nombre_curso,
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => $this->curso->nombre_curso,
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

        $usuario_sesion = $this->obtener_usuario_autenticado();
        $this->modo_admin = $usuario_sesion->esRol('ADMINISTRADOR');
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->mostrar_datos_curso();
        $this->mostrar_silabus();
        $this->obtener_datos_page_header();

    }


    public function render()
    {
        return view('livewire.gestion-aula.silabus.index');
    }
}
