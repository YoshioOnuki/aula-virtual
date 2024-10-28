<?php

namespace App\Livewire\AlumnosDocentes;

use Livewire\Component;

class Index extends Component
{
    public $tipo_vista;

    public $titulo_page_header;
    public $regresar_page_header;
    public $links_page_header;


    /**
     * Obtener datos para mostrar el componente Page Header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = $this->tipo_vista === 'cursos' ? 'ALUMNOS' : 'DOCENTES';

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];
    }


    public function mount()
    {
        $this->tipo_vista = request()->routeIs('alumnos*') ? 'cursos' : 'carga-academica';
        $this->obtener_datos_page_header();
    }

    public function render()
    {
        return view('livewire.alumnos-docentes.index');
    }
}
