<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\ArchivoAlumno;
use App\Models\ArchivoDocente;
use App\Models\EstadoTrabajoAcademico;
use App\Models\GestionAula;
use App\Models\GestionAulaAlumno;
use App\Models\TrabajoAcademico;
use App\Models\TrabajoAcademicoAlumno;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Vinkla\Hashids\Facades\Hashids;

class Detalle extends Component
{
    use WithFileUploads;
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $trabajo_academico;

    // Variable para verificar si el alumno ya entrego el trabajo académico
    public $entrega_trabajo = false;
    public $trabajo_academico_alumno;

    // Variables para el modal de Trabajo Académico
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Entrega de Trabajo Académico';
    public $accion_modal = 'Agregar';
    #[Validate('nullable')]
    public $descripcion_trabajo_academico_alumno;
    #[Validate(['archivos_trabajo_alumno.*' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt,jpg,jpeg,png,webp|max:4096'])]
    public $archivos_trabajo_alumno = [];
    public $nombre_archivo_trabajo_academico = [];
    public $iteration = 1;

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;


    /**
     * Abrir modal para agregar entrega de trabajo académico
     */
    public function abrir_modal_entrega_trabajo()
    {
        $this->limpiar_modal();

        $this->modo = 1;
        $this->titulo_modal = 'Agregar Entrega de Trabajo Académico';
        $this->accion_modal = 'Agregar';
    }


    /**
     * Subir archivo de la entrega del trabajo académico
     */
    public function subir_archivo_entrega()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula);
        array_push($carpetas, 'trabajos-academicos-alumnos');

        $nombres_bd = [];

        foreach ($this->archivos_trabajo_alumno as $archivo)
        {
            $nombre_archivo_trabajo = null;
            $extension_archivo = strtolower($archivo->getClientOriginalExtension());

            $extensiones_permitidas = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension_archivo, $extensiones_permitidas))
            {
                continue; // Si la extensión no está permitida, saltar al siguiente archivo
            }

            $nombre_bd = subir_archivo($archivo, $nombre_archivo_trabajo, $carpetas, $extension_archivo);
            $nombres_bd[] = $nombre_bd; // Guardar el nombre del archivo en la base de datos

            // Guardar el nombre del archivo original
            $this->nombre_archivo_trabajo_academico[] = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
        }

        return $nombres_bd; // Retornar un array con los nombres de los archivos guardados
    }


    /**
     * Eliminar archivo de la entrega del trabajo académico
     */
    public function eliminar_archivo_entrega($nombres_archivos)
    {
        foreach ($nombres_archivos as $ruta)
        {
            eliminar_archivo($ruta);
        }
    }


    /**
     * Obtener el texto de la descripción del trabajo académico
     */
    public function texto_descripcion_trabajo()
    {
        $mensaje = $this->descripcion_trabajo_academico_alumno;
        $mensaje = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $mensaje . '</body></html>';

        return $mensaje;
    }


    /**
     * Verificar si el usuario ya entrego el trabajo académico
     */
    public function verificar_entrega_trabajo()
    {
        $id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
            ->gestionAula($this->id_gestion_aula)
            ->first()->id_gestion_aula_alumno ?? null;

        $this->trabajo_academico_alumno = TrabajoAcademicoAlumno::with('estadoTrabajoAcademico')
            ->where('id_trabajo_academico', $this->trabajo_academico->id_trabajo_academico)
            ->where('id_gestion_aula_alumno', $id_gestion_aula_alumno)
            ->first();

        if ($this->trabajo_academico_alumno) {
            $this->entrega_trabajo = true;
        } else {
            $this->entrega_trabajo = false;
        }
    }


    /**
     * Guardar la entrega del trabajo académico
     */
    public function guardar_entrega_trabajo()
    {
        if (($this->descripcion_trabajo_academico_alumno === '<p><br></p>'
            || $this->descripcion_trabajo_academico_alumno === '<h1><br></h1>' ||
            $this->descripcion_trabajo_academico_alumno === '<h2><br></h2>' ||
            $this->descripcion_trabajo_academico_alumno === '<h3><br></h3>' ||
            $this->descripcion_trabajo_academico_alumno === '<h4><br></h4>' ||
            $this->descripcion_trabajo_academico_alumno === '<h5><br></h5>' ||
            $this->descripcion_trabajo_academico_alumno === '<h6><br></h6>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h2><br></h2>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h3><br></h3>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h4><br></h4>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h5><br></h5>' ||
            $this->descripcion_trabajo_academico_alumno === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h6><br></h6>' ||
            $this->descripcion_trabajo_academico_alumno === '<p></p>' || $this->descripcion_trabajo_academico_alumno === '' ||
            $this->descripcion_trabajo_academico_alumno === null) && count($this->archivos_trabajo_alumno) <= 0)
        {
            $this->dispatch(
                'toast-basico',
                mensaje: 'Debe ingresar la descripción del trabajo académico o subir un archivo',
                type: 'error'
            );
            return;
        }

        try {
            DB::beginTransaction();

            if (!verificar_fecha_trabajo($this->trabajo_academico->fecha_inicio_trabajo_academico, $this->trabajo_academico->fecha_fin_trabajo_academico))
            {
                $this->cerrar_modal();
                $this->limpiar_modal();
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se puede entregar el trabajo académico, ya que la fecha de entrega ha finalizado',
                    type: 'error'
                );
                return;
            } else {
                if (count($this->archivos_trabajo_alumno) > 0)
                {
                    $nombres_bd = $this->subir_archivo_entrega();
                }

                // Obtener el texto de la descripción del trabajo
                $descripcion_trabajo = subir_archivo_editor($this->descripcion_trabajo_academico_alumno, 'archivos/posgrado/media/editor-texto/trabajos-academicos-alumnos/');

                if ($this->modo === 1) // Modo agregar
                {
                    // Obtener el estado del trabajo académico
                    $estado_trabajo = EstadoTrabajoAcademico::where('nombre_estado_trabajo_academico', 'Entregado')->first();

                    $id_gestion_aula_alumno = GestionAulaAlumno::where('id_usuario', $this->usuario->id_usuario)
                    ->gestionAula($this->id_gestion_aula)
                    ->first()->id_gestion_aula_alumno ?? null;

                    // Crear el trabajo académico Alumno
                    $trabajo_academico_alumno = new TrabajoAcademicoAlumno();
                    $trabajo_academico_alumno->descripcion_trabajo_academico_alumno = $descripcion_trabajo;
                    $trabajo_academico_alumno->nota_trabajo_academico_alumno = -1;
                    $trabajo_academico_alumno->id_estado_trabajo_academico = $estado_trabajo->id_estado_trabajo_academico;
                    $trabajo_academico_alumno->id_trabajo_academico = $this->trabajo_academico->id_trabajo_academico;
                    $trabajo_academico_alumno->id_gestion_aula_alumno = $id_gestion_aula_alumno;
                    $trabajo_academico_alumno->save();
                    // Guardar el archivos
                    if (count($this->archivos_trabajo_alumno) > 0)
                    {
                        foreach ($nombres_bd as $nombre_bd)
                        {
                            $archivo_alumno = new ArchivoAlumno();
                            $archivo_alumno->nombre_archivo_alumno = $this->nombre_archivo_trabajo_academico[array_search($nombre_bd, $nombres_bd)];
                            $archivo_alumno->archivo_alumno = $nombre_bd;
                            $archivo_alumno->id_trabajo_academico_alumno = $trabajo_academico_alumno->id_trabajo_academico_alumno;
                            $archivo_alumno->save();
                        }
                    }
                } else { // Modo editar
                    // Editar el trabajo académico
                }

                $this->dispatch('actualizar_estado_trabajo');
                $this->verificar_entrega_trabajo();

                DB::commit();

                if (count($this->archivos_trabajo_alumno) <= 0)
                {
                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'La entrega del trabajo académico se ha guardado correctamente, pero no se ha subido ningún archivo',
                        type: 'info'
                    );
                } else {
                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'La entrega del trabajo académico se ha guardado correctamente',
                        type: 'success'
                    );
                }

                $this->cerrar_modal();
                $this->limpiar_modal();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($nombres_bd)) {
                $this->eliminar_archivo_entrega($nombres_bd);
            }
            // dd($e);
            $this->cerrar_modal();
            $this->limpiar_modal();
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar la entrega del trabajo académico',
                type: 'error'
            );
        }
    }


    /**
     * Cerrar modal
     */
    public function cerrar_modal($modal = '#modal-entrega')
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
        $this->titulo_modal = 'Agregar Entrega de Trabajo Académico';
        $this->accion_modal = 'Agregar';
        $this->reset([
            'descripcion_trabajo_academico_alumno',
            'archivos_trabajo_alumno'
        ]);
        $this->iteration++;

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Descargar archivo del trabajo académico, con el nombre original
     */
    public function descargar_archivo(ArchivoDocente $archivo)
    {
        $ruta = $archivo->archivo_docente;
        return response()->download($ruta, $archivo->nombre_archivo_docente . '.' . pathinfo($ruta, PATHINFO_EXTENSION));
    }


    /**
     * Obtener datos para el componente page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Detalle del Trabajo Académico';

        // Regresar
        if ($this->tipo_vista === 'cursos') {
            $this->regresar_page_header = [
                'route' => 'cursos.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->regresar_page_header = [
                'route' => 'carga-academica.detalle.trabajo-academico',
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

        // Links --> Trabajos académicos
        if ($this->tipo_vista === 'cursos') {
            $this->links_page_header[] = [
                'name' => 'Trabajos académicos',
                'route' => 'cursos.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        } else {
            $this->links_page_header[] = [
                'name' => 'Trabajos académicos',
                'route' => 'carga-academica.detalle.trabajo-academico',
                'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]
            ];
        }
    }


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_trabajo_academico)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $id_trabajo_academico = Hashids::decode($id_trabajo_academico);
        $this->trabajo_academico = TrabajoAcademico::with('archivoDocente')->find($id_trabajo_academico[0]);

        $this->obtener_datos_page_header();
        $this->verificar_entrega_trabajo();
    }


    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.detalle');
    }
}
