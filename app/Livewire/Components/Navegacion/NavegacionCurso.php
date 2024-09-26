<?php

namespace App\Livewire\Components\Navegacion;

use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class NavegacionCurso extends Component
{

    public $id_usuario_hash;
    public $id_gestion_aula_usuario_hash;
    public $tipo_vista;
    public $links_array = [];


    public function get_link()
    {

        if($this->tipo_vista === 'cursos')
        {
            // Silabus
            $this->links_array [] =
            [
                'name' => 'Silabus',
                'route' => 'cursos.detalle.silabus',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Recursos
            $this->links_array [] =
            [
                'name' => 'Recursos',
                'route' => 'cursos.detalle.recursos',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Foro
            $this->links_array [] =
            [
                'name' => 'Foro',
                'route' => 'cursos.detalle.foro',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Asistencia
            $this->links_array [] =
            [
                'name' => 'Asistencia',
                'route' => 'cursos.detalle.asistencia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Trabajos Academicos
            $this->links_array [] =
            [
                'name' => 'Trabajos Académicos',
                'route' => 'cursos.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Webgrafia
            $this->links_array [] =
            [
                'name' => 'Webgrafia',
                'route' => 'cursos.detalle.webgrafia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else
        {
            // Silabus
            $this->links_array [] =
            [
                'name' => 'Silabus',
                'route' => 'carga-academica.detalle.silabus',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Recursos
            $this->links_array [] =
            [
                'name' => 'Recursos',
                'route' => 'carga-academica.detalle.recursos',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Foro
            $this->links_array [] =
            [
                'name' => 'Foro',
                'route' => 'carga-academica.detalle.foro',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Asistencia
            $this->links_array [] =
            [
                'name' => 'Asistencia',
                'route' => 'carga-academica.detalle.asistencia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Trabajos Academicos
            $this->links_array [] =
            [
                'name' => 'Trabajos Académicos',
                'route' => 'carga-academica.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Webgrafia
            $this->links_array [] =
            [
                'name' => 'Webgrafia',
                'route' => 'carga-academica.detalle.webgrafia',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
            // Alumnos
            $this->links_array [] =
            [
                'name' => 'Alumnos',
                'route' => 'carga-academica.detalle.alumnos',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        }
    }


    public function placeholder()
    {
        return <<<'HTML'
        <div class="my-5 d-flex justify-content-center">
            <div class="spinner-border text-blue" role="status"></div>
        </div>
        HTML;
    }


    public function mount($id_usuario, $id_gestion_aula_usuario, $tipo_vista)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->id_gestion_aula_usuario_hash = Hashids::encode($id_gestion_aula_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->get_link();
    }


    public function render()
    {
        return view('livewire.components.navegacion.navegacion-curso');
    }
}
