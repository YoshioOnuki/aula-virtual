<?php

namespace App\Livewire\GestionAula\Webgrafia;

use App\Models\GestionAula;
use App\Models\Webgrafia;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    use UsuarioTrait;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;
    #[Url('buscar')]
    public $search = '';

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;

    // Variables para el modal de Recursos
    public $modo = 1; // Modo 1 = Registrar / 0 = Editar
    public $titulo_modal = 'Registrar Webgrafía';
    public $accion_estado = 'Registrar';
    #[Validate('required')]
    public $descripcion_webgrafia;
    #[Validate('required|url')]
    public $link_webgrafia;
    public $editar_webgrafia;


    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $estado_carga_modal = true; // Para manejar el estado de carga del modal
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Webgrafía';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Abrir modal para editar webgrafía
     */
    public function abrir_modal_webgrafia_editar(Webgrafia $webgrafia)
    {
        $this->limpiar_modal();

        $this->modo = 0;
        $this->titulo_modal = 'Editar Recurso';
        $this->accion_estado = 'Editar';

        $this->editar_webgrafia = Webgrafia::find($webgrafia->id_webgrafia);
        $this->descripcion_webgrafia = $this->editar_webgrafia->descripcion_webgrafia;
        $this->link_webgrafia = $this->editar_webgrafia->link_webgrafia;

        $this->estado_carga_modal = false;
    }


    /**
     * Abrir modal para registrar webgrafía
     */
    public function abrir_modal_webgrafia_registrar()
    {
        $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Registrar webgrafia';
        $this->accion_estado = 'Registrar';

        $this->estado_carga_modal = false;
    }


    /**
     * Guardar webgrafía
     */
    public function guardar_webgrafia()
    {
        $this->validate();

        try
        {
            DB::beginTransaction();

            if($this->modo === 1) // Registrar
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
            $this->limpiar_modal();

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


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-webgrafia')
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    /**
     * Limpiar modal
     */
    public function limpiar_modal()
    {
        $this->estado_carga_modal = true;

        $this->modo = 1;
        $this->titulo_modal = 'Crear Webgrafía';
        $this->accion_estado = 'Crear';
        $this->descripcion_webgrafia = '';
        $this->link_webgrafia = '';
        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener datos para el page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Webgrafía';

        // Regresar
        if($this->tipo_vista === 'cursos')
        {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
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

        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);
        $nombre_curso = $gestion_aula->curso->nombre_curso . ' GRUPO ' . $gestion_aula->grupo_gestion_aula;

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos')
        {
            $this->links_page_header[] = [
                'name' => $nombre_curso,
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => $nombre_curso,
                'route' => 'carga-academica.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }

    }


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

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
