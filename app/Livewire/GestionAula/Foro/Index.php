<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\ForoRespuesta;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $ruta_pagina;
    public $foros;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;




    public function abrir_modal_agregar_foro()
    {
        dd('abrir_modal_agregar_foro');
    }


    public function obtener_foros()
    {
        $id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;
        $this->foros = Foro::where('id_gestion_aula', $id_gestion_aula)
            ->orderBy('created_at', 'desc')
            ->get();

        // foreach ($foros as $foro) {
        //     $foro->id_foro_hash = Hashids::encode($foro->id_foro);
        //     $foro->id_usuario_hash = Hashids::encode($foro->id_usuario);
        //     $foro->usuario = Usuario::find($foro->id_usuario);
        //     $foro->respuestas = ForoRespuesta::where('id_foro', $foro->id_foro)
        //         ->orderBy('created_at', 'asc')
        //         ->get();
        //     foreach ($foro->respuestas as $respuesta) {
        //         $respuesta->id_foro_respuesta_hash = Hashids::encode($respuesta->id_foro_respuesta);
        //         $respuesta->id_usuario_hash = Hashids::encode($respuesta->id_usuario);
        //         $respuesta->usuario = Usuario::find($respuesta->id_usuario);
        //     }
        // }
    }


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Foro';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        }

        // Links --> Inicio
        $this->links_page_header = [
            [
                'name' => 'Inicio',
                'route' => 'inicio',
                'params' => []
            ]
        ];

        // Links --> Cursos o Carga Académica
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Mis Cursos',
                'route' => 'cursos',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Carga Académica',
                'route' => 'carga-academica',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista]
            ];
        }

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Detalle',
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Detalle',
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        }
    }
    /* ==================================================================================== */


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $user = Auth::user();
        $usuario_sesion = Usuario::find($user->id_usuario);
        if ($usuario_sesion->esRol('ADMINISTRADOR')) {
            $this->modo_admin = true;
        }

        $this->ruta_pagina = request()->route()->getName();

        $this->obtener_datos_page_header();
        $this->obtener_foros();
    }


    public function render()
    {
        return view('livewire.gestion-aula.foro.index');
    }
}
