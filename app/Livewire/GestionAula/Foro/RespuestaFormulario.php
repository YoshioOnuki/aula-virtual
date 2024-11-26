<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\ForoRespuesta;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class RespuestaFormulario extends Component
{
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $id_gestion_aula_alumno;
    public $id_foro;
    public $id_foro_hash;
    public $id_foro_respuesta;
    public $foro;
    public $foro_respuesta;
    public $nivel;

    // Variables para el formulario de respuesta
    #[Validate('required')]
    public $descripcion_foro_respuesta;
    public $descripcion_foro_respuesta_anterior;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente_invitado = false;
    public $modo_respuesta_respuesta = false; // Modo respuesta de respuesta, para saber si se esta respondiendo una respuesta
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;

    // Modificar el mensaje de error para la validación
    protected $messages = [
        'descripcion_foro_respuesta.required' => 'El campo de respuesta es obligatorio.'
    ];


    /**
     * Función para guardar la respuesta
     */
    public function guardar_respuesta()
    {
        if (
            $this->descripcion_foro_respuesta === '<p><br></p>' || $this->descripcion_foro_respuesta === '<h1><br></h1>' ||
            $this->descripcion_foro_respuesta === '<h2><br></h2>' ||
            $this->descripcion_foro_respuesta === '<h3><br></h3>' ||
            $this->descripcion_foro_respuesta === '<h4><br></h4>' ||
            $this->descripcion_foro_respuesta === '<h5><br></h5>' ||
            $this->descripcion_foro_respuesta === '<h6><br></h6>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h2><br></h2>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h3><br></h3>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h4><br></h4>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h5><br></h5>' ||
            $this->descripcion_foro_respuesta === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h6><br></h6>' ||
            $this->descripcion_foro_respuesta === '<p></p>' || $this->descripcion_foro_respuesta === '' ||
            $this->descripcion_foro_respuesta === null
        ) {
            $this->dispatch(
                'toast-basico',
                mensaje: 'El campo de respuesta es obligatorio.',
                type: 'error'
            );
            $this->descripcion_foro_respuesta = limpiar_editor_vacio($this->descripcion_foro_respuesta);
            $this->validate();
            return;
        }

        $this->descripcion_foro_respuesta = limpiar_editor_vacio($this->descripcion_foro_respuesta);
        $this->validate();

        try {
            DB::beginTransaction();

            $mensaje = subir_archivo_editor($this->descripcion_foro_respuesta, 'archivos/posgrado/media/editor-texto/foros/');
            // Eliminar archivos de la descripción anterior
            if ($this->descripcion_foro_respuesta_anterior) {
                $deletedFiles = eliminar_comparando_archivos_editor($mensaje, $this->descripcion_foro_respuesta_anterior, 'archivos/posgrado/media/editor-texto/foros/');
            }

            if ($this->modo_respuesta_respuesta) {
                $foro_respuesta = ForoRespuesta::find($this->id_foro_respuesta);
                $foro_respuesta->Hijos()->create([
                    'descripcion_foro_respuesta' => $mensaje,
                    'id_foro' => $foro_respuesta->id_foro,
                    'id_gestion_aula_alumno' => $this->id_gestion_aula_alumno,
                ]);
            } else {
                $this->foro->ForoRespuesta()->create([
                    'descripcion_foro_respuesta' => $mensaje,
                    'id_gestion_aula_alumno' => $this->id_gestion_aula_alumno,
                ]);
            }

            DB::commit();

            // session([
            //     'mensaje_exito_respuesta' => 'La respuesta se guardó correctamente.',
            //     'id' => $this->id_foro
            // ]);
            
            if ($this->tipo_vista === 'cursos') {
                return redirect()->route('cursos.detalle.foro.detalle', [
                    'id_usuario' => $this->id_usuario_hash,
                    'tipo_vista' => $this->tipo_vista,
                    'id_curso' => $this->id_gestion_aula_hash,
                    'id_foro' => $this->id_foro_hash
                ])->with('mensaje_exito_respuesta', 'La respuesta se guardó correctamente.');
            } else {
                return redirect()->route('carga-academica.detalle.foro.detalle', [
                    'id_usuario' => $this->id_usuario_hash,
                    'tipo_vista' => $this->tipo_vista,
                    'id_curso' => $this->id_gestion_aula_hash,
                    'id_foro' => $this->id_foro_hash
                ])->with('mensaje_exito_respuesta', 'La respuesta se guardó correctamente.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar la respuesta.',
                type: 'error'
            );
        }

    }


    /**
     * Obtener el foro y sus respuestas
     */
    public function obtener_foro_a_responder()
    {
        if ($this->modo_respuesta_respuesta) {
            $this->foro_respuesta = ForoRespuesta::with('gestionAulaAlumno.usuario')->find($this->id_foro_respuesta);
        } else {
            $this->foro = Foro::with('gestionAulaDocente.usuario')->find($this->id_foro);
        }
    }


    /**
     * Obtener datos para mostrar en el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Respuesta al Foro';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle.foro.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_foro' => $this->id_foro_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle.foro.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_foro' => $this->id_foro_hash]
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

        // Links --> Detalle del foro
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Detalle del Foro',
                'route' => 'cursos.detalle.foro.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_foro' => $this->id_foro_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Detalle del Foro',
                'route' => 'carga-academica.detalle.foro.detalle',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash, 'id_foro' => $this->id_foro_hash]
            ];
        }
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_foro, $id_foro_respuesta = null, $nivel = 0)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);
        $this->id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
            ->gestionAula($this->id_gestion_aula)
            ->first()->id_gestion_aula_alumno;

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->id_foro_hash = $id_foro;
        $this->id_foro = Hashids::decode($id_foro)[0];
        $this->id_foro_respuesta = $id_foro_respuesta ? Hashids::decode($id_foro_respuesta)[0] : null;
        $this->nivel = $nivel;
        $this->modo_respuesta_respuesta = $id_foro_respuesta ? true : false;

        $this->obtener_datos_page_header();
        $this->obtener_foro_a_responder();
    }


    public function render()
    {
        if (!$this->usuario->esAlumno($this->id_gestion_aula)) {
            abort(403);
        } elseif ($this->nivel >= 3) {
            abort(403);
        } else {
            return view('livewire.gestion-aula.foro.respuesta-formulario');
        }
    }
}
