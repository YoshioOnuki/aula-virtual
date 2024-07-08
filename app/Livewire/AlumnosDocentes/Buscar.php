<?php

namespace App\Livewire\AlumnosDocentes;

use App\Models\Usuario;
use Livewire\Attributes\Url;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Buscar extends Component
{
    #[Url('buscar')]
    public $search = '';

    public $usuarios;
    public $tipo_vista;


    public function mostrar_carga_academica($id)
    {
        session(['modo_admin' => true]);
        $id_usuario = Hashids::encode($id);
        return redirect()->route('carga-academica', ['id_usuario' => $id_usuario, 'tipo_vista' => $this->tipo_vista]);
    }

    public function mostrar_cursos($id)
    {
        session(['modo_admin' => true]);
        $id_usuario = Hashids::encode($id);
        return redirect()->route('cursos', ['id_usuario' => $id_usuario, 'tipo_vista' => $this->tipo_vista]);
    }


    public function mostrar_usuarios()
    {
        $this->usuarios = Usuario::with('persona', 'roles', 'accionUsuario')
            ->where('estado_usuario', 1)
            ->whereHas('roles', function($query){
                if($this->tipo_vista == 'cursos'){
                    $query->where('nombre_rol', 'ALUMNO');
                }else{
                    $query->whereIn('nombre_rol', ['DOCENTE', 'DOCENTE INVITADO']);
                }
            })->where(function($query) {
                if($this->tipo_vista === 'cursos')
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


    public function mount($tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;

        if($this->search || $this->search != '')
        {
            $this->mostrar_usuarios();
        }else{
            $this->usuarios = Collect();
        }

    }

    public function render()
    {
        return view('livewire.alumnos-docentes.buscar');
    }
}
