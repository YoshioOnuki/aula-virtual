<?php

namespace App\Livewire\AlumnosDocentes;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    public $tipo_vista;

    public $titulo_page_header;
    public $regresar_page_header;
    public $links_page_header;


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            if($this->tipo_vista === 'cursos')
            {
                $this->titulo_page_header = 'ALUMNOS';
            } else {
                $this->titulo_page_header = 'DOCENTES';
            }

            // Links --> Inicio
            $this->links_page_header = [
                [
                    'name' => 'Inicio',
                    'route' => 'inicio',
                    'params' => []
                ]
            ];

        }
    /* ===================================================================================== */


    public function mount()
    {
        if(request()->routeIs('alumnos*'))
        {
            $this->tipo_vista = 'cursos';
        }elseif(request()->routeIs('docentes*'))
        {
            $this->tipo_vista = 'carga-academica';
        }

        $this->obtener_datos_page_header();

    }

    public function render()
    {
        return view('livewire.alumnos-docentes.index');
    }
}
