<?php

namespace App\Livewire\GestionAula\Recurso;

use App\Models\GestionAulaUsuario;
use Livewire\Component;

class Index extends Component
{
    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;
    public $curso;
    public $recursos;

    public $estado_recurso = 0; // 0 => Hecho, 1 => Pendiente

    public $cargando_recursos = true;
    public $cargando_datos_curso = true;
    public $cantidad_recursos = 1;

    public function cambiar_estado_recurso()
    {
        if($this->estado_recurso === 0)
        {
            $this->estado_recurso = 1;
        }else{
            $this->estado_recurso = 0;
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

    public function mostrar_recursos()
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
                    'recurso' => function ($query) {
                        $query->select('id_recurso', 'nombre_recurso', 'archivo_recurso', 'id_gestion_aula');
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if ($this->gestion_aula_usuario) {
            $this->recursos = $this->gestion_aula_usuario->gestionAula->recurso;
        }
    }

    public function load_recursos()
    {
        $this->mostrar_recursos();
        $this->cargando_recursos = false;
    }

    public function load_datos_curso()
    {
        $this->mostrar_datos_curso();
        $this->cargando_datos_curso = false;
    }

    public function calcular_cantidad_recursos()
    {
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'recurso' => function ($query) {
                        $query->select('id_recurso');
                    }
                ])->select('id_gestion_aula');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        $this->cantidad_recursos = $this->gestion_aula_usuario->gestionAula->recurso->count();

        $this->cantidad_recursos === 0 ? $this->cantidad_recursos = 1 : $this->cantidad_recursos;
    }


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
    public function load_recursos_llamar()
    {
        $this->dispatch('load_recursos_evento');
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

        $this->calcular_cantidad_recursos();
    }

    public function render()
    {
        return view('livewire.gestion-aula.recurso.index');
    }
}
