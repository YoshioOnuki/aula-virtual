<?php

namespace App\Livewire\GestionAula\Asistencia;

use App\Models\Asistencia;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;

    public $modo_admin = false;


    public function updatingMostrarPaginate()
    {
        $this->resetPage();
    }


    public function mount($id_usuario, $id_curso)
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

        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        if(request()->routeIs('alumnos*') || request()->routeIs('docentes*'))
        {
            $this->modo_admin = true;
        }

    }

    public function render()
    {

        $gestion_aula_usuario = GestionAulaUsuario::with([
            'gestionAula' => function ($query) {
                $query->select('id_gestion_aula');
            }
        ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

        if(session('tipo_vista') === 'alumno')
        {
            $asistencias = Asistencia::with([
                'asistenciaAlumno' => function ($query) {
                    $query->with([
                        'estadoAsistencia' => function ($query) {
                            $query->select('id_estado_asistencia', 'nombre_estado_asistencia');
                        },
                        'gestionAulaUsuario' => function ($query) {
                            $query->where('id_usuario', $this->usuario->id_usuario)
                                ->select('id_gestion_aula_usuario', 'id_gestion_aula', 'id_usuario');
                        }
                    ])->select('id_asistencia_alumno', 'id_estado_asistencia', 'id_asistencia', 'id_gestion_aula_usuario');
                }
            ])->where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'desc')
                ->orderBy('hora_inicio_asistencia', 'desc')
                ->paginate($this->mostrar_paginate);

        }elseif(session('tipo_vista') === 'docente')
        {
            $asistencias = Asistencia::where('id_gestion_aula', $gestion_aula_usuario->gestionAula->id_gestion_aula)
                ->search($this->search)
                ->orderBy('fecha_asistencia', 'desc')
                ->orderBy('hora_inicio_asistencia', 'desc')
                ->paginate($this->mostrar_paginate);
        }

        return view('livewire.gestion-aula.asistencia.index', [
            'asistencias' => $asistencias,
        ]);
    }
}
