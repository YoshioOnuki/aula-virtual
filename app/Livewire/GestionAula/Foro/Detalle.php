<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\ForoRespuesta;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Traits\UsuarioTrait;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Detalle extends Component
{
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $id_gestion_aula_alumno;

    public $id_foro;
    public $foro;
    public $foro_respuestas;

    // Variables para eliminar respuesta
    public $id_foro_respuesta_a_eliminar;
    public $creacion_foro_respuesta_a_eliminar;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;

    protected $listeners = ['abrir_modal_eliminar_respuesta' => 'abrir_modal_eliminar_respuesta'];


    /**
     * Mostrar toast de éxito
     */
    public function mostrar_toast()
    {
        $this->dispatch(
            'toast-basico',
            mensaje: 'La respuesta se guardó correctamente.',
            type: 'success'
        );
    }


    /**
     * Abrir modal para eliminar respuesta
     */
    public function abrir_modal_eliminar_respuesta($id_foro_respuesta)
    {
        $this->limpiar_modal_eliminar();
        $this->id_foro_respuesta_a_eliminar = $id_foro_respuesta;
        $this->creacion_foro_respuesta_a_eliminar = ForoRespuesta::find($id_foro_respuesta)->created_at;

        $this->modal('#modal-eliminar-respuesta', 'show');
    }


    /**
     * Eliminar respuesta
     */
    public function eliminar_respuesta()
    {
        $foro_respuesta = ForoRespuesta::find($this->id_foro_respuesta_a_eliminar);

        if ($foro_respuesta) {
            //Eliminar archivos
            $eliminar_archivos = eliminar_archivos_editor($foro_respuesta->descripcion_foro_respuesta, 'archivos/posgrado/media/editor-texto/foros/');

            // Elimnar respuestas hijos
            if ($foro_respuesta->hijos->count() > 0) {
                foreach ($foro_respuesta->hijos as $hijo) {
                    $eliminar_archivos_hijos = eliminar_archivos_editor($hijo->descripcion_foro_respuesta, 'archivos/posgrado/media/editor-texto/foros/');
                    $hijo->delete();
                }
            }

            // Eliminar respuesta
            $foro_respuesta->delete();
            // Cerrar modal
            $this->modal('#modal-eliminar-respuesta', 'hide');
            // Limpiar modal
            $this->limpiar_modal_eliminar();
            // Mensaje de éxito
            $this->dispatch(
                'toast-basico',
                mensaje: 'La respuesta se eliminó correctamente.',
                type: 'success'
            );
            // Actualizar respuestas
            $this->obtener_foro();
        }
    }


    /**
     * Cerrar modal
     */
    public function modal($modal = '#modal-eliminar-respuesta', $action = 'hide')
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: $action
        );
    }


    /**
     * Limpiar el modal de eliminar
     */
    public function limpiar_modal_eliminar()
    {
        $this->reset([
            'id_foro_respuesta_a_eliminar',
            'creacion_foro_respuesta_a_eliminar'
        ]);

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener datos para mostrar en el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Detalle del Foro';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle.foro',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle.foro',
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
        $nombre_curso = $gestion_aula->curso->nombre_curso . ' GRUPO ' . $gestion_aula->grupo_gestion_aula;

        // Links --> Detalle del curso o carga académica
        if ($this->tipo_vista === 'cursos') {
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

        // Links --> Foro
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Foro',
                'route' => 'cursos.detalle.foro',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Foro',
                'route' => 'carga-academica.detalle.foro',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }
    }


    /**
     * Obtener el foro y sus respuestas
     */
    public function obtener_foro()
    {
        $this->foro = Foro::with([
            'foroRespuesta' => function ($query) {
                $query->with('gestionAulaAlumno.usuario')
                    ->where('id_respuesta_padre', null)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        ])->find($this->id_foro);
        $this->foro_respuestas = $this->foro->foroRespuesta;
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_foro)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->id_foro = Hashids::decode($id_foro)[0];

        if($this->usuario->esAlumno($this->id_gestion_aula)) {
            $this->id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
                ->gestionAula($this->id_gestion_aula)
                ->first()->id_gestion_aula_alumno ?? null;
        }

        $this->obtener_datos_page_header();
        $this->obtener_foro();
    }


    public function render()
    {
        return view('livewire.gestion-aula.foro.detalle');
    }
}
