<?php

namespace App\Livewire\GestionAula\Alumnos;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $id_gestion_aula;


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
        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

        $this->usuario = Usuario::find(auth()->id());

    }

    public function render()
    {
        $alumnos = GestionAulaUsuario::with([
            'usuario' => function ($query) {
                $query->with([
                    'persona' => function ($query) {
                        $query->select('id_persona', 'documento_persona', 'nombres_persona', 'apellido_paterno_persona', 'apellido_materno_persona', 'codigo_alumno_persona', 'correo_persona');
                    }
                ])->select('id_usuario', 'correo_usuario', 'foto_usuario', 'estado_usuario', 'id_persona');
            },
            'rol' => function ($query) {
                $query->select('id_rol', 'nombre_rol', 'estado_rol');
            },
        ])->where('id_gestion_aula', $this->id_gestion_aula)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })
            ->paginate($this->mostrar_paginate);
        // dd($alumnos);

        return view('livewire.gestion-aula.alumnos.index', [
            'alumnos' => $alumnos
        ]);
    }
}
