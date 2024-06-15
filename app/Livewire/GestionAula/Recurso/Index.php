<?php

namespace App\Livewire\GestionAula\Recurso;

use App\Models\GestionAulaUsuario;
use App\Models\Recurso;
use App\Models\Usuario;
use Livewire\Component;

class Index extends Component
{
    public $usuario;

    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;
    public $curso;
    public $recursos;

    public $estado_recurso = 0; // 0 => Hecho, 1 => Pendiente

    public $cargando_recursos = true;
    public $cargando_datos_curso = true;
    public $cantidad_recursos = 1;

    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Estado de Usuario';
    public $accion_estado = 'Agregar';
    public $nombre_recurso;
    public $archivo_recurso;

    public function cambiar_estado_recurso()
    {
        if($this->estado_recurso === 0)
        {
            $this->estado_recurso = 1;
        }else{
            $this->estado_recurso = 0;
        }
    }

    public function cerrar_modal()
    {
        $this->limpiar_modal();
        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'hide'
        );
    }

    public function limpiar_modal()
    {
        $this->modo = 1;
        $this->titulo_modal = 'Estado de Usuario';
        $this->accion_estado = 'Agregar';
        $this->nombre_recurso = '';
    }

    // public function abrir_modal_recurso_editar(Recurso $recurso)
    public function abrir_modal_recurso_editar($recurso)
    {
        $this->limpiar_modal();

        $this->modo = 0;
        $this->titulo_modal = 'Editar Recurso';
        $this->accion_estado = 'Editar';

        $this->nombre_recurso = 'asdasdas';

        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'show'
        );
    }

    public function abrir_modal_recurso_agregar()
    {
        $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Agregar Recurso';
        $this->accion_estado = 'Agregar';

        $this->dispatch(
            'modal',
            modal: '#modal-recursos',
            action: 'show'
        );

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

        $this->usuario = Usuario::find(auth()->id());

    }

    public function render()
    {
        return view('livewire.gestion-aula.recurso.index');
    }
}
