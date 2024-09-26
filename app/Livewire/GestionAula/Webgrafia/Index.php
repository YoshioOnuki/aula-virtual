<?php

namespace App\Livewire\GestionAula\Webgrafia;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use App\Models\Webgrafia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
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
    public $id_gestion_aula;

    // Variables para el modal de Recursos
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Webgrafía';
    public $accion_estado = 'Agregar';
    #[Validate('nullable')]
    public $descripcion_webgrafia;
    #[Validate('required')]
    public $link_webgrafia;
    public $editar_webgrafia;


    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Webgrafía';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;


    /* =============== FUNCIONES PARA EL MODAL DE WEBGRAFIA - AGREGAR Y EDITAR =============== */
    public function abrir_modal_webgrafia_editar(Webgrafia $webgrafia)
    {
        $this->limpiar_modal();

        $this->modo = 0;
        $this->titulo_modal = 'Editar Recurso';
        $this->accion_estado = 'Editar';

        $this->editar_webgrafia = Webgrafia::find($webgrafia->id_webgrafia);
        $this->descripcion_webgrafia = $this->editar_webgrafia->descripcion_webgrafia;
        $this->link_webgrafia = $this->editar_webgrafia->link_webgrafia;
    }

    public function abrir_modal_webgrafia_agregar()
    {
        $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Agregar webgrafia';
        $this->accion_estado = 'Agregar';
    }

    public function guardar_webgrafia()
    {
        $this->validate();


        try
        {
            DB::beginTransaction();

            if($this->modo === 1) // Agregar
            {
                $webgrafia = new Webgrafia();
                $webgrafia->descripcion_webgrafia = $this->descripcion_webgrafia ?? null;
                $webgrafia->link_webgrafia = $this->link_webgrafia;
                $webgrafia->id_gestion_aula = $this->id_gestion_aula;
                $webgrafia->save();
            }else{ // Editar
                $webgrafia = Webgrafia::find($this->editar_webgrafia->id_webgrafia);
                if($this->descripcion_webgrafia)
                {
                    $webgrafia->descripcion_webgrafia = $this->descripcion_webgrafia;
                }
                $webgrafia->link_webgrafia = $this->link_webgrafia;
                $webgrafia->save();
            }

            DB::commit();

            $this->cerrar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'La Webgrafía se ha guardado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar la Webgrafía',
                type: 'error'
            );
        }

    }

    public function cerrar_modal()
    {
        $this->limpiar_modal();
    }

    public function limpiar_modal()
    {
        $this->modo = 1;
        $this->titulo_modal = 'Crear Webgrafía';
        $this->accion_estado = 'Crear';
        $this->descripcion_webgrafia = '';
        $this->link_webgrafia = '';
        // Reiniciar errores
        $this->resetErrorBag();
    }


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Webgrafía';

        // Regresar
        if($this->tipo_vista === 'cursos')
        {
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
        if ($this->tipo_vista === 'cursos')
        {
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

        $curso = GestionAulaUsuario::with('gestionAula.curso')->find($this->id_gestion_aula_usuario);

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos')
        {
            $this->links_page_header[] = [
                'name' => $curso->gestionAula->curso->nombre_curso,
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => $curso->gestionAula->curso->nombre_curso,
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
            ];
        }

    }

    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;

        $this->id_gestion_aula_usuario_hash = $id_curso;
        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];
        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;


        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $user = Auth::user();
        $usuario_sesion = Usuario::find($user->id_usuario);

        if ($usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }
        $this->obtener_datos_page_header();

    }


    public function render()
    {
        $webgrafias = Webgrafia::search($this->search)
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.webgrafia.index', [
            'webgrafias' => $webgrafias
        ]);
    }
}
