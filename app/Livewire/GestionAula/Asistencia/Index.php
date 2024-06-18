<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $usuario;

    public $id_gestion_aula_usuario;
    public $gestion_aula_usuario;

    public $asistencias;
    public $cargando = true;


    public function mostrar_asistencias()
    {
        $this->gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->with([
                    'asistencia' => function ($query) {
                        $query->with([
                            'asistenciaAlumno' => function ($query) {
                                $query->with([
                                    'estadoAsistencia' => function ($query) {
                                        $query->select('id_estado_asistencia', 'nombre_estado_asistencia');
                                    }
                                ])->select('id_asistencia_alumno', 'id_estado_asistencia', 'id_asistencia', 'id_gestion_aula_usuario');
                            }
                        ])->search($this->search)
                        ->orderBy('fecha_asistencia', 'desc')
                        ->orderBy('hora_inicio_asistencia', 'desc')
                        ->paginate($this->mostrar_paginate);
                    }
                ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        // dd($this->id_gestion_aula_usuario);
        // dd($this->gestion_aula_usuario->gestionAula->asistencia);
        $this->asistencias = $this->gestion_aula_usuario->gestionAula->asistencia;

    }

    public function load_asistencias()
    {
        $this->mostrar_asistencias();
        $this->cargando = false;
    }


    /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */
    public function load_asistencias_llamar()
    {
        $this->dispatch('load_asistencias_evento');
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

        $this->usuario = Usuario::find(auth()->id());

    }

    public function render()
    {
        // $asistencias = Asistencia::search($this->search)
        //     ->orderBy('fecha_asistencia', 'desc')
        //     ->orderBy('hora_inicio_asistencia', 'desc')
        //     ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.asistencia.index', [
            // 'asistencias' => $asistencias
        ]);
    }
}
