<?php

namespace App\Livewire\GestionAula\Silabus;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    public $usuario;
    public $id_usuario_hash;

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $curso;
    public $silabus_pdf;// Variable para mostrar el silabus

    // Variables para subir el silabus
    #[Validate('required|file|mimes:pdf|max:4096')]
    public $silabus;

    // Variables para carga de datos
    public $cargando_datos_curso = true;
    public $cargando_silabus = true;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Silabus';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    /* =============== GUARDAR Y ACTUALIZAR SILABUS =============== */
    public function subir_silabus()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula_usuario);

        $archivo = $this->silabus;
        $nombre_silabus = $this->silabus_pdf->archivo_silabus ?? null;
        array_push($carpetas, 'silabus');
        $extencion_archivo = 'pdf';
        $nombre_bd = subir_archivo($archivo, $nombre_silabus, $carpetas, $extencion_archivo);

        return $nombre_bd;
    }

    public function guardar_silabus()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $nombre_bd = $this->subir_silabus();

            $gestion_aula_usuario = GestionAulaUsuario::find($this->id_gestion_aula_usuario);

            if ($gestion_aula_usuario) {
                $gestion_aula_usuario->gestionAula->silabus()->updateOrCreate(
                    ['id_gestion_aula' => $gestion_aula_usuario->id_gestion_aula],
                    ['archivo_silabus' => $nombre_bd]
                );
            }

            DB::commit();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El silabus se ha guardado correctamente',
                type: 'success'
            );

            $this->silabus_pdf = $gestion_aula_usuario->gestionAula->silabus;
            $this->reset('silabus');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el silabus: '.$e->getMessage(),
                type: 'error'
            );
        }

    }


    /* =============== CARGAR DATOS PARA MOSTRAR INDEPENDIENTEMENTE =============== */
    public function mostrar_datos_curso()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
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
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();


        if ($gestion_aula_usuario) {
            $this->curso = $gestion_aula_usuario->gestionAula->curso;
        }
    }

    public function mostrar_silabus()
    {
        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'silabus' => function ($query) {
                        $query->select('id_silabus', 'id_gestion_aula', 'archivo_silabus');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($gestion_aula_usuario) {
            $this->silabus_pdf = $gestion_aula_usuario->gestionAula->silabus;
        }


    }

    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Silabus';

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

    /* =============== HACER EL LLAMADO DE LA CARGA DE DATOS PARA CAMBIAR EL ESTADO DEL PLACEHOLDER =============== */
    public function load_datos_curso()
    {
        $this->mostrar_datos_curso();
        $this->cargando_datos_curso = false;
    }

    public function load_silabus()
    {
        $this->mostrar_silabus();
        $this->cargando_silabus = false;
    }


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
    public function load_silabus_llamar()
    {
        $this->dispatch('load_silabus_evento');
    }

    public function load_datos_curso_llamar()
    {
        $this->dispatch('load_datos_curso_evento');
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
        return view('livewire.gestion-aula.silabus.index');
    }
}
