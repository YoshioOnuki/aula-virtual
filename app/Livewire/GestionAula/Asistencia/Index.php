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

    public  $asistencias;
    public $cargando = true;

    public $total_registros;
    public $mostrando_inicio;
    public $mostrando_fin;
    public $hay_mas_paginas;


    public function updatedMostrarPaginate($value)
    {
        $this->mostrar_asistencias();
    }

    public function mostrar_asistencias()
    {

        if(session('tipo_vista') === 'alumno')
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
                                ->orderBy('hora_inicio_asistencia', 'desc');
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        }elseif(session('tipo_vista') === 'docente')
        {
            $this->gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'asistencia' => function ($query) {
                            $query->search($this->search)
                                ->orderBy('fecha_asistencia', 'desc')
                                ->orderBy('hora_inicio_asistencia', 'desc');
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        }

        if (!$this->gestion_aula_usuario || !$this->gestion_aula_usuario->gestionAula || !$this->gestion_aula_usuario->gestionAula->asistencia) {
            $this->asistencias = collect();
            return;
        }

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

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => Collect(),
        ]);
    }
}
