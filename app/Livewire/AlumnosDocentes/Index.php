<?php

namespace App\Livewire\AlumnosDocentes;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{

    #[Url('buscar')]
    public $search = '';

    public $usuarios;


    public function mostrar_carga_academica($id)
    {
        $id_usuario = encriptar($id);
        session(['id_usuario' => $id_usuario]);
        return redirect()->route('docentes.carga-academica');

    }

    public function mostrar_cursos($id)
    {
        $id_usuario = encriptar($id);
        session(['id_usuario' => $id_usuario]);
        return redirect()->route('alumnos.cursos');
    }


    public function mostrar_usuarios()
    {
        $this->usuarios = Usuario::with('persona', 'roles', 'accionUsuario')
            ->where('estado_usuario', 1)
            ->whereHas('roles', function($query){
                if(session('tipo_vista') == 'alumno'){
                    $query->where('nombre_rol', 'ALUMNO');
                }else{
                    $query->whereIn('nombre_rol', ['DOCENTE', 'DOCENTE INVITADO']);
                }
            })->where(function($query) {
                if(session('tipo_vista') === 'alumno')
                {
                    $query->searchAlumno($this->search);
                }else{
                    $query->search($this->search);
                }
            })->get();

            $this->usuarios = $this->usuarios->sortBy(function ($usuario) {
                return $usuario->persona->apellido_paterno_persona . ' ' . $usuario->persona->apellido_materno_persona;
            });
    }

    public function updatedSearch()
    {
        if ($this->search || $this->search != '') {
            $this->mostrar_usuarios();
        }else{
            $this->usuarios = Collect();
        }
    }

    public function mount()
    {
        if(request()->routeIs('alumnos*'))
        {
            session(['tipo_vista' => 'alumno']);
        }elseif(request()->routeIs('docentes*'))
        {
            session(['tipo_vista' => 'docente']);
        }

        if($this->search || $this->search != ''){

            $this->mostrar_usuarios();

        }else{
            $this->usuarios = Collect();
        }

    }

    public function render()
    {

        return view('livewire.alumnos-docentes.index');
    }
}
