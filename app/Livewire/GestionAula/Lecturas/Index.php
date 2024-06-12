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
            $this->curso = $this->gestion_aula_usuario->gestionAula->curso;
            $this->lecturas = $this->gestion_aula_usuario->gestionAula->lectura;
        }

    }

    public function render()
    {
        return view('livewire.gestion-aula.lecturas.index');
    }
}
