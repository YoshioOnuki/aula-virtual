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

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $curso;
    public $silabus_pdf;

    #[Validate('required|file|mimes:pdf|max:4096')]
    public $silabus;

    public $cargando_datos_curso = true;
    public $cargando_silabus = true;

    public $modo_admin = false;

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


    public function mount($id)
    {
        if(request()->routeIs('cursos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('carga-academica*'))
        {
            session(['tipo_vista' => 'docente']);
        }elseif(request()->routeIs('alumnos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('docentes*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        $this->id_gestion_aula_usuario_hash = $id;

        $id_gestion_aula_usuario = Hashids::decode($id);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        if(request()->routeIs('alumnos*') || request()->routeIs('docentes*'))
        {
            if(session('id_usuario') !== null)
            {
                $id_usuario = Hashids::decode(session('id_usuario'));
                $this->usuario = Usuario::find($id_usuario[0]);
                $this->modo_admin = true;
            }else{
                request()->routeIs('alumnos*') ? redirect()->route('alumnos') : redirect()->route('docentes');
            }
        }else{
            $this->usuario = Usuario::find(auth()->id());
        }

    }



    public function render()
    {
        return view('livewire.gestion-aula.silabus.index');
    }
}
