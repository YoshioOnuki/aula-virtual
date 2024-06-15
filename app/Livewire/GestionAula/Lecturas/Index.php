<?php

namespace App\Livewire\GestionAula\Lecturas;

use App\Models\GestionAulaUsuario;
use Livewire\Component;

class Index extends Component
{
    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;
    public $curso;
    public $lecturas;

    public $lectura_leida = 0;

    public $cargando_lectuas = true;
    public $cargando_datos_curso = true;
    public $cantidad_lecturas = 1;

    public function marcar_lectura_leida()
    {
        if($this->lectura_leida === 0)
        {
            $this->lectura_leida = 1;
        }else{
            $this->lectura_leida = 0;
        }
    }


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

    public function mostrar_lecturas()
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
                    'lectura' => function ($query) {
                        $query->select('id_lectura', 'nombre_lectura', 'archivo_lectura', 'id_gestion_aula');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($this->gestion_aula_usuario) {
            $this->lecturas = $this->gestion_aula_usuario->gestionAula->lectura;
        }
    }

    public function load_lecturas()
    {
        $this->mostrar_lecturas();
        $this->cargando_lectuas = false;
    }

    public function load_datos_curso()
    {
        $this->mostrar_datos_curso();
        $this->cargando_datos_curso = false;
    }

    public function calcular_cantidad_lecturas()
    {
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'lectura' => function ($query) {
                        $query->select('id_lectura');
                    }
                ])->select('id_gestion_aula');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $this->cantidad_lecturas = $this->gestion_aula_usuario->gestionAula->lectura->count();

        $this->cantidad_lecturas === 0 ? $this->cantidad_lecturas = 1 : $this->cantidad_lecturas;
    }


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
    public function load_lecturas_llamar()
    {
        $this->dispatch('load_lecturas_evento');
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

        $this->calcular_cantidad_lecturas();
    }

    public function render()
    {
        return view('livewire.gestion-aula.lecturas.index');
    }
}
