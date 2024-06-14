<?php

namespace App\Livewire\GestionAula\Silabus;

use App\Models\GestionAulaUsuario;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $id_gestion_aula_usuario;
    public $curso;
    public $silabus_pdf;

    #[Validate('required|file|mimes:pdf|max:2048')]
    public $silabus;

    public $cargando_datos_curso = true;
    public $cargando_silabus = true;

    public function guardar_silabus()
    {
        $this->validate();
        dd($this->silabus);

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
        // usleep(1000000);
        $this->mostrar_datos_curso();
        $this->cargando_datos_curso = false;
    }

    public function load_silabus()
    {
        // usleep(300000);
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
        }

        $this->id_gestion_aula_usuario = desencriptar($id);

    }



    public function render()
    {
        return view('livewire.gestion-aula.silabus.index');
    }
}
