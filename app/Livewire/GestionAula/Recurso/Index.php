<?php

namespace App\Livewire\GestionAula\Recurso;

use App\Models\GestionAula;
use App\Models\Recurso;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    use UsuarioTrait;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 3;
    #[Url('buscar')]
    public $search = '';

    public $usuario;
    public $id_usuario_hash;
    public $gestion_aula;
    public $id_gestion_aula;
    public $id_gestion_aula_hash;

    // Variables para la carga de datos
    public $cargando_datos_curso = true;

    // Variables para el modal de Recursos
    public $modo = 1; // Modo 1 = Registrar / 0 = Editar
    public $titulo_modal = 'Registrar Recurso';
    public $accion_estado = 'Registrar';
    #[Validate('required')]
    public $nombre_recurso;
    #[Validate('required|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt|max:4096')]
    public $archivo_recurso;
    public $editar_recurso;
    public $cerrar_modal = false;
    public $estado_carga_modal = true; // Para manejar el estado de carga del modal

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Recursos';
    public $links_page_header = [];
    public $regresar_page_header;

    protected $listeners = ['abrir-modal-recurso-editar' => 'abrir_modal_recurso_editar'];


    /**
     * Abrir modal para editar un recurso
     */
    public function abrir_modal_recurso_editar(Recurso $recurso)
    {
        // $this->limpiar_modal();

        $this->modo = 0;
        $this->titulo_modal = 'Editar Recurso';
        $this->accion_estado = 'Editar';

        $this->editar_recurso = Recurso::find($recurso->id_recurso);
        $this->nombre_recurso = $this->editar_recurso->nombre_recurso;

        $this->estado_carga_modal = false;
    }


    /**
     * Abrir modal para registrar un recurso
     */
    public function abrir_modal_recurso_registrar()
    {
        // $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Registrar Recurso';
        $this->accion_estado = 'Registrar';

        $this->estado_carga_modal = false;
    }


    /**
     * Subir archivo del recurso
     */
    public function subir_archivo_recurso()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula);

        $archivo = $this->archivo_recurso;
        $nombre_archivo_recurso = $this->editar_recurso->archivo_recurso ?? null;
        array_push($carpetas, 'recursos');
        $extension_archivo = strtolower($archivo->getClientOriginalExtension());

        $extensiones_permitidas = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt'];

        if (in_array($extension_archivo, $extensiones_permitidas)) {
            $extencion_archivo = $extension_archivo;
        } else {
            return null;
        }

        $nombre_bd = subir_archivo($archivo, $nombre_archivo_recurso, $carpetas, $extencion_archivo);

        return $nombre_bd;
    }


    /**
     * Validar y guardar el recurso
     */
    public function guardar_recurso()
    {
        $this->validate();

        try
        {
            DB::beginTransaction();

            $nombre_bd = $this->subir_archivo_recurso();

            if($this->modo === 1)
            {
                $recurso = new Recurso();
                $recurso->nombre_recurso = $this->nombre_recurso;
                $recurso->archivo_recurso = $nombre_bd;
                $recurso->id_gestion_aula = $this->id_gestion_aula;
                $recurso->save();
            }else{
                $recurso = Recurso::find($this->editar_recurso->id_recurso);
                $recurso->nombre_recurso = $this->nombre_recurso;
                $recurso->archivo_recurso = $nombre_bd;
                $recurso->save();
            }

            DB::commit();

            $this->cerrar_modal();
            $this->limpiar_modal();
            // Evento para recargar los recursos
            $this->dispatch('load-recursos');

            $this->dispatch(
                'toast-basico',
                mensaje: 'El recurso se ha guardado correctamente',
                type: 'success'
            );


        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el recurso',
                type: 'error'
            );
        }
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-recursos')
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
        $this->modo = 1;
        $this->titulo_modal = 'Registrar Recurso';
        $this->accion_estado = 'Registrar';
        $this->nombre_recurso = '';
        $this->editar_recurso = null;
        $this->reset('archivo_recurso');
        // Reiniciar errores
        $this->resetErrorBag();
        // Reiniciar estado de carga
        $this->estado_carga_modal = true;
    }


    /**
     * Obtener datos para el page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Recursos';

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

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos')
        {
            $this->links_page_header[] = [
                'name' => $gestion_aula->curso->nombre_curso,
                'route' => 'cursos.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => $gestion_aula->curso->nombre_curso,
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
        $recursos = Recurso::where('id_gestion_aula', $this->id_gestion_aula)
            ->orderBy('created_at', 'desc')
            ->search($this->search)
            ->paginate($this->mostrar_paginate);

        return view('livewire.gestion-aula.recurso.index',[
            'recursos' => $recursos
        ]);
    }
}
