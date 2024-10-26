<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\GestionAula;
use App\Models\GestionAulaDocente;
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

    // Variables para el modal de Foros
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Foro';
    public $accion_modal = 'Agregar';
    public $editar_foro;
    #[Validate('required')]
    public $titulo_foro;
    #[Validate('required')]
    public $descripcion_foro;
    #[Validate('required')]
    public $fecha_inicio_foro;
    #[Validate('required')]
    public $fecha_fin_foro;
    #[Validate('required')]
    public $hora_inicio_foro;
    #[Validate('required')]
    public $hora_fin_foro;

    // Variables para eliminar foro
    public $id_foro_a_eliminar;
    public $titulo_foro_a_eliminar;
    public $fecha_inicio_foro_a_eliminar;
    public $fecha_fin_foro_a_eliminar;

    // Variables para duplicar foro
    public $id_foro_a_duplicar;
    public $titulo_foro_a_duplicar;
    public $fecha_inicio_foro_a_duplicar;
    public $fecha_fin_foro_a_duplicar;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;

    protected $listeners = ['abrir-modal-foro-editar' => 'abrir_modal_editar_foro'];


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

        $this->editar_foro = Foro::find($id_foro);
        $this->titulo_foro = $this->editar_foro->titulo_foro;
        $this->descripcion_foro = $this->editar_foro->descripcion_foro;
        $this->fecha_inicio_foro = $this->editar_foro->fecha_inicio_foro->format('Y-m-d');
        $this->fecha_fin_foro = $this->editar_foro->fecha_fin_foro->format('Y-m-d');
        $this->hora_inicio_foro = $this->editar_foro->fecha_inicio_foro->format('H:i');
        $this->hora_fin_foro = $this->editar_foro->fecha_fin_foro->format('H:i');
    }


    /**
     * Abrir modal para eliminar un foro
     */
    public function abrir_modal_eliminar_foro($id_foro)
    {
        $foro = Foro::find($id_foro);
        $this->id_foro_a_eliminar = $id_foro;
        $this->titulo_foro_a_eliminar = $foro->titulo_foro;
        $this->fecha_inicio_foro_a_eliminar = format_fecha_horas($foro->fecha_inicio_foro);
        $this->fecha_fin_foro_a_eliminar = format_fecha_horas($foro->fecha_fin_foro);
    }


    /**
     * Abrir modal para duplicar un foro
     */
    public function abrir_modal_duplicar_foro($id_foro)
    {
        $foro = Foro::find($id_foro);
        $this->id_foro_a_duplicar = $id_foro;
        $this->titulo_foro_a_duplicar = $foro->titulo_foro;
        $this->fecha_inicio_foro_a_duplicar = format_fecha_horas($foro->fecha_inicio_foro);
        $this->fecha_fin_foro_a_duplicar = format_fecha_horas($foro->fecha_fin_foro);
    }


    /**
     * Guardar foro
     */
    public function guardar_foro()
    {
        $this->validate([
            'titulo_foro' => 'required',
            'descripcion_foro' => 'required',
            'fecha_inicio_foro' => 'required|before_or_equal:fecha_fin_foro|date',
            'fecha_fin_foro' => 'required|after_or_equal:fecha_inicio_foro|date',
            'hora_inicio_foro' => 'required|date_format:H:i|before_or_equal:hora_fin_foro',
            'hora_fin_foro' => 'required|date_format:H:i|after_or_equal:hora_inicio_foro',
        ]);

        try {
            DB::beginTransaction();

            if ($this->modo === 1) // Modo agregar
            {
                $id_gestion_aula_docente = GestionAulaDocente::where('id_usuario', $this->usuario->id_usuario)
                    ->gestionAula($this->id_gestion_aula)
                    ->first()
                    ->id_gestion_aula_docente;

                $foro = new Foro();
                $foro->titulo_foro = $this->titulo_foro;
                $foro->descripcion_foro = $this->descripcion_foro;
                $foro->fecha_inicio_foro = $this->fecha_inicio_foro . ' ' . $this->hora_inicio_foro;
                $foro->fecha_fin_foro = $this->fecha_fin_foro . ' ' . $this->hora_fin_foro;
                $foro->id_gestion_aula_docente = $id_gestion_aula_docente;
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

            $this->cerrar_modal();
            $this->limpiar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El foro se ha guardado correctamente',
                type: 'success'
            );

            // Evento para actualizar la lista de foros
            $this->dispatch('actualizar-foros');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar el trabajo academico',
                type: 'error'
            );
        }
    }


    /**
     * Eliminar foro
     */
    public function eliminar_foro($id_foro)
    {
        try {
            DB::beginTransaction();

            // Buscar respuesta del foro para eliminar
            $foro = Foro::with('foroRespuesta')
                ->find($id_foro);

            if ($foro->foroRespuesta->count() > 0) {
                $foro->foroRespuesta()->delete();
            }
            $foro->delete();

            DB::commit();

            $this->cerrar_modal('#modal-eliminar');
            $this->limpiar_modal_eliminar();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El foro se ha eliminado correctamente',
                type: 'success'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al eliminar el foro',
                type: 'error'
            );
        }
    }


    /**
     * Duplicar foro
     */
    public function duplicar_foro($id_foro)
    {
        try {
            DB::beginTransaction();

            $id_gestion_aula_docente = GestionAulaDocente::where('id_usuario', $this->usuario->id_usuario)
                ->gestionAula($this->id_gestion_aula)
                ->first()
                ->id_gestion_aula_docente;

            $foro = Foro::find($id_foro);

            $nuevo_foro = new Foro();
            $nuevo_foro->titulo_foro = $foro->titulo_foro . ' (Copia)';
            $nuevo_foro->descripcion_foro = $foro->descripcion_foro;
            $nuevo_foro->fecha_inicio_foro = $foro->fecha_inicio_foro;
            $nuevo_foro->fecha_fin_foro = $foro->fecha_fin_foro;
            $nuevo_foro->id_gestion_aula_docente = $id_gestion_aula_docente;
            $nuevo_foro->id_gestion_aula = $foro->id_gestion_aula;
            $nuevo_foro->save();

            DB::commit();

            $this->cerrar_modal('#modal-duplicar');
            $this->limpiar_modal_duplicar();

            $this->dispatch(
                'toast-basico',
                mensaje: 'El foro se ha duplicado correctamente',
                type: 'success'
            );

            // Evento para actualizar la lista de foros
            $this->dispatch('actualizar-foros');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al duplicar el foro',
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
     * Limpiar el modal de eliminar
     */
    public function limpiar_modal_eliminar()
    {
        $this->reset([
            'id_foro_a_eliminar',
            'titulo_foro_a_eliminar',
            'fecha_inicio_foro_a_eliminar',
            'fecha_fin_foro_a_eliminar'
        ]);

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Limpiar el modal de duplicar
     */
    public function limpiar_modal_duplicar()
    {
        $this->reset([
            'id_foro_a_duplicar',
            'titulo_foro_a_duplicar',
            'descripcion_foro_a_duplicar',
            'fecha_inicio_foro_a_duplicar',
            'fecha_fin_foro_a_duplicar'
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
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

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
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.gestion-aula.foro.index', [
            'foros' => $foros
        ]);
    }
}
