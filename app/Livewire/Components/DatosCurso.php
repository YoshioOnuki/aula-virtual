<?php

namespace App\Livewire\Components;

use App\Models\GestionAulaUsuario;
use Livewire\Component;

class DatosCurso extends Component
{

    public $curso;
    public $gestion_aula_usuario;
    public $id_gestion_aula_usuario;

    public $link_clase = ' ';

    public $cargando_datos_curso = true;

    public $datos = false;

    public $tipo_vista; // Para saber que tipo de vista se está mostrando

    protected $listeners = ['actualizar_datos_curso' => 'load_datos_curso'];



    /* =============== MOSTRAR DATOS DEL CURSO =============== */

        public function mostrar_datos_curso()
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
                        'linkClase' => function ($query) {
                            $query->select('id_link_clase', 'id_gestion_aula', 'nombre_link_clase');
                        },
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

            if ($this->gestion_aula_usuario) {
                $this->curso = $this->gestion_aula_usuario->gestionAula->curso;
            }
        }

        public function load_datos_curso()
        {
            // usleep(300000);
            $this->mostrar_datos_curso();
            $this->cargando_datos_curso = false;
        }

    /* ======================================================= */

    /* =============== REDIRECCIONAR A LINK DE LA CLASE =============== */
        public function redireccionar_link_clase()
        {
            if(!$this->gestion_aula_usuario->gestionAula->linkClase)
            {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El link de la clase no está disponible',
                    type: 'error'
                );
            }else{
                $this->dispatch('redirectLink', $this->gestion_aula_usuario->gestionAula->linkClase->nombre_link_clase);
            }
        }
    /* =============================================================== */


    public function mount($id_gestion_aula_usuario, $tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario;

        if(request()->routeIs('cursos.detalle') ||
            request()->routeIs('carga-academica.detalle') ||
            request()->routeIs('alumnos.cursos.detalle') ||
            request()->routeIs('docentes.carga-academica.detalle'))
        {
            $this->datos = true;
        }
    }


    public function render()
    {
        return view('livewire.components.datos-curso');
    }
}
