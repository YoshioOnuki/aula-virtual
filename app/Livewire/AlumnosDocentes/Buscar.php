<?php

namespace App\Livewire\AlumnosDocentes;

use App\Models\Usuario;
use Livewire\Attributes\Url;
use Livewire\Component;

class Buscar extends Component
{
    #[Url('buscar')]
    public $search = '';

    public $usuarios;
    public $tipo_vista;


    /**
     * Mostrar usuarios
     */
    public function mostrar_usuarios()
    {
        $this->usuarios = Usuario::with('persona', 'roles', 'auditoria.accion')
            ->activo()
            ->whereHas('roles', function($query){
                if($this->tipo_vista == 'cursos'){
                    $query->where('nombre_rol', 'ALUMNO');
                }else{
                    $query->where('nombre_rol', 'DOCENTE');
                }
            })->where(function($query) {
                if($this->tipo_vista === 'cursos')
                {
                    $query->searchAlumno($this->search);
                }else{
                    $query->searchDocente($this->search);
                }
            })
                ->take(20)
                ->get();

            $this->usuarios = $this->usuarios->sortBy(function ($usuario) {
                return $usuario->persona->nombres_persona . ' ' . $usuario->persona->apellido_paterno_persona . ' ' . $usuario->persona->apellido_materno_persona;
            });
    }


    /**
     * Actualizar busqueda de usuarios en tiempo real
     */
    public function updatedSearch()
    {
        if ($this->search || $this->search != '') {
            $this->mostrar_usuarios();
        }else{
            $this->usuarios = Collect();
        }
    }


    /**
     * Placeholder para la carga diferida
     */
    public function placeholder()
    {
        return <<<'HTML'
        <div class="mt-8 d-flex justify-content-center">
            <div class="spinner-border text-blue" role="status"></div>
        </div>
        HTML;
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
