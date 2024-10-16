<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\GestionAula;
use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use App\Traits\UsuarioTrait;
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

    // Variables para el modal de Foros
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Foro';
    public $accion_modal = 'Agregar';
    public $editar_foro;
    #[Validate('required')]
    public $titulo_foro;
    #[Validate('nullable')]
    public $descripcion_foro;
    #[Validate('required')]
    public $fecha_inicio_foro;
    #[Validate('required')]
    public $fecha_fin_foro;
    #[Validate('required')]
    public $hora_inicio_foro;
    #[Validate('required')]
    public $hora_fin_foro;

    protected $listeners = ['abrir-modal-foro-editar' => 'abrir_modal_editar_foro'];

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Abrir modal para agregar un foro
     */
    public function abrir_modal_agregar_foro()
    {
        $this->limpiar_modal();
        $this->modo = 1;
        $this->titulo_modal = 'Agregar Foro';
        $this->accion_modal = 'Agregar';
    }


    /**
     * Abrir modal para editar un foro
     */
    public function abrir_modal_editar_foro($id_foro)
    {
        $this->limpiar_modal();
        $this->modo = 0;
        $this->titulo_modal = 'Editar Foro';
        $this->accion_modal = 'Editar';

        // $this->editar_trabajo_academico = TrabajoAcademico::find($id_trabajo_academico);
        // $this->nombre_trabajo_academico = $this->editar_trabajo_academico->titulo_trabajo_academico;
        // $this->descripcion_trabajo_academico = $this->editar_trabajo_academico->descripcion_trabajo_academico;
        // $this->fecha_inicio_trabajo_academico = date('Y-m-d', strtotime($this->editar_trabajo_academico->fecha_inicio_trabajo_academico));
        // $this->fecha_fin_trabajo_academico = date('Y-m-d', strtotime($this->editar_trabajo_academico->fecha_fin_trabajo_academico));
        // $this->hora_inicio_trabajo_academico = date('H:i', strtotime($this->editar_trabajo_academico->fecha_inicio_trabajo_academico));
        // $this->hora_fin_trabajo_academico = date('H:i', strtotime($this->editar_trabajo_academico->fecha_fin_trabajo_academico));
    }


    /**
     * Guardar foro
     */
    public function guardar_foro()
    {
        $this->validate([
            'titulo_foro' => 'required',
            'descripcion_foro' => 'nullable',
            'fecha_inicio_foro' => 'required|before_or_equal:fecha_fin_foro|date',
            'fecha_fin_foro' => 'required|after_or_equal:fecha_inicio_foro|date',
            'hora_inicio_foro' => 'required|date_format:H:i|before_or_equal:hora_fin_foro',
            'hora_fin_foro' => 'required|date_format:H:i|after_or_equal:hora_inicio_foro',
        ]);

        try {
            DB::beginTransaction();

            if ($this->modo === 1) // Modo agregar
            {
                $foro = new Foro();
                $foro->titulo_foro = $this->titulo_foro;
                $foro->descripcion_foro = $this->descripcion_foro;
                $foro->fecha_inicio_foro = $this->fecha_inicio_foro . ' ' . $this->hora_inicio_foro;
                $foro->fecha_fin_foro = $this->fecha_fin_foro . ' ' . $this->hora_fin_foro;
                $foro->id_gestion_aula = $this->id_gestion_aula;
                $foro->save();
            } else { // Modo editar
                $foro = Foro::find($this->editar_foro->id_foro);
                $foro->titulo_foro = $this->titulo_foro;
                $foro->descripcion_foro = $this->descripcion_foro;
                $foro->fecha_inicio_foro = $this->fecha_inicio_foro . ' ' . $this->hora_inicio_foro;
                $foro->fecha_fin_foro = $this->fecha_fin_foro . ' ' . $this->hora_fin_foro;
                $foro->save();
            }

            DB::commit();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El foro se ha guardado correctamente',
                type: 'success'
            );

            $this->cerrar_modal();
            $this->limpiar_modal();

            // Evento para actualizar la lista de foros
            $this->dispatch('actualizar-foros');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el trabajo academico',
                type: 'error'
            );
        }
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-foro')
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    /**
     * Limpiar el modal
     */
    public function limpiar_modal()
    {
        $this->modo = 1;
        $this->titulo_modal = 'Agregar Foro';
        $this->accion_modal = 'Agregar';
        $this->reset([
            'titulo_foro',
            'descripcion_foro',
            'fecha_inicio_foro',
            'fecha_fin_foro',
            'hora_inicio_foro',
            'hora_fin_foro'
        ]);

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener los datos para el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Foro';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
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

        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos') {
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

        $this->obtener_datos_page_header();
    }


    public function render()
    {
        $foros = Foro::with([
            'foroRespuesta' => function ($query) {
                $query->with('gestionAulaAlumno.usuario')
                    ->orderBy('created_at', 'desc')->first(); // Última respuesta ordenada por fecha
            },
            'gestionAulaDocente' => function ($query) {
                $query->with('usuario');
            }
        ])
            ->withCount('foroRespuesta') // Cuenta la cantidad de respuestas
            ->gestionAula($this->id_gestion_aula)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.gestion-aula.foro.index', [
            'foros' => $foros
        ]);
    }
}
