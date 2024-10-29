<?php

namespace App\Livewire\GestionAula\Foro;

use App\Models\Foro;
use App\Models\GestionAula;
use App\Models\GestionAulaDocente;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class ForoFormulario extends Component
{
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;
    public $tipo_vista;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $id_foro;

    public $modo; // 1: Registrar, 0: Editar
    public $descripcion_foro_anterior;
    #[Validate('required')]
    public $titulo_foro;
    #[Validate('required')]
    public $descripcion_foro;
    #[Validate('required|before_or_equal:fecha_fin_foro|date')]
    public $fecha_inicio_foro;
    #[Validate('required|after_or_equal:fecha_inicio_foro|date')]
    public $fecha_fin_foro;
    #[Validate('required|date_format:H:i|before_or_equal:hora_fin_foro')]
    public $hora_inicio_foro;
    #[Validate('required|date_format:H:i|after_or_equal:hora_inicio_foro')]
    public $hora_fin_foro;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Guardar foro
     */
    public function guardar_foro()
    {
        if (
            $this->descripcion_foro === '<p><br></p>' || $this->descripcion_foro === '<h1><br></h1>' ||
            $this->descripcion_foro === '<h2><br></h2>' ||
            $this->descripcion_foro === '<h3><br></h3>' ||
            $this->descripcion_foro === '<h4><br></h4>' ||
            $this->descripcion_foro === '<h5><br></h5>' ||
            $this->descripcion_foro === '<h6><br></h6>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h2><br></h2>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h3><br></h3>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h4><br></h4>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h5><br></h5>' ||
            $this->descripcion_foro === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h6><br></h6>' ||
            $this->descripcion_foro === '<p></p>' || $this->descripcion_foro === '' ||
            $this->descripcion_foro === null
        ) {
            $this->dispatch(
                'toast-basico',
                mensaje: 'El campo de descripción del foro es obligatorio',
                type: 'error'
            );
            $this->validate();
            return;
        }

        $this->validate();

        try {
            DB::beginTransaction();

            $mensaje = subir_archivo_editor($this->descripcion_foro, 'archivos/posgrado/media/editor-texto/foros/');
            // Eliminar archivos de la descripción anterior
            if ($this->descripcion_foro_anterior) {
                $deletedFiles = eliminar_comparando_archivos_editor($mensaje, $this->descripcion_foro_anterior, 'archivos/posgrado/media/editor-texto/foros/');
                // dd($deletedFiles);
            }

            if ($this->modo === 1) // Modo agregar
            {
                $id_gestion_aula_docente = GestionAulaDocente::where('id_usuario', $this->usuario->id_usuario)
                    ->gestionAula($this->id_gestion_aula)
                    ->first()
                    ->id_gestion_aula_docente;

                $foro = new Foro();
                $foro->titulo_foro = $this->titulo_foro;
                $foro->descripcion_foro = $mensaje;
                $foro->fecha_inicio_foro = $this->fecha_inicio_foro . ' ' . $this->hora_inicio_foro;
                $foro->fecha_fin_foro = $this->fecha_fin_foro . ' ' . $this->hora_fin_foro;
                $foro->id_gestion_aula_docente = $id_gestion_aula_docente;
                $foro->id_gestion_aula = $this->id_gestion_aula;
                $foro->save();
            } else { // Modo editar
                $foro = Foro::find($this->id_foro);
                $foro->titulo_foro = $this->titulo_foro;
                $foro->descripcion_foro = $mensaje;
                $foro->fecha_inicio_foro = $this->fecha_inicio_foro . ' ' . $this->hora_inicio_foro;
                $foro->fecha_fin_foro = $this->fecha_fin_foro . ' ' . $this->hora_fin_foro;
                $foro->save();
            }

            DB::commit();

            session(['mensaje_exito' => 'El foro se guardó correctamente.']);

            return redirect()->route('carga-academica.detalle.foro', [
                'id_usuario' => $this->id_usuario_hash,
                'tipo_vista' => $this->tipo_vista,
                'id_curso' => $this->id_gestion_aula_hash
            ]);
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
     * Obtener datos para editar el foro
     */
    public function obtener_datos_foro()
    {
        $foro = Foro::find($this->id_foro);

        $this->titulo_foro = $foro->titulo_foro;
        $this->descripcion_foro = $foro->descripcion_foro;
        $this->descripcion_foro_anterior = $foro->descripcion_foro;
        $this->fecha_inicio_foro = $foro->fecha_inicio_foro->format('Y-m-d');
        $this->fecha_fin_foro = $foro->fecha_fin_foro->format('Y-m-d');
        $this->hora_inicio_foro = $foro->fecha_inicio_foro->format('H:i');
        $this->hora_fin_foro = $foro->fecha_fin_foro->format('H:i');
    }


    /**
     * Obtener datos para mostrar en el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = $this->modo === 1 ? 'Registrar Foro' : 'Editar Foro';

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


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_foro = null)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);
        $this->id_foro = $id_foro ? Hashids::decode($id_foro)[0] : null;
        $this->modo = $id_foro ? 0 : 1;

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente = $this->usuario->esDocente($this->id_gestion_aula);
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->obtener_datos_page_header();
        if ($this->modo === 0) {
            $this->obtener_datos_foro();
        }
    }


    public function render()
    {
        if ($this->es_docente) {
            return view('livewire.gestion-aula.foro.foro-formulario');
        } else {
            abort(403);
        }
    }
}
