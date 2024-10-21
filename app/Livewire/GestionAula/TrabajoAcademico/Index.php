<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\ArchivoDocente;
use App\Models\GestionAula;
use App\Models\TrabajoAcademico;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;
    use UsuarioTrait;

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $trabajos_academicos;

    // Variables para el modal de Trabajo Académico
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Trabajo Académico';
    public $accion_modal = 'Agregar';
    public $editar_trabajo_academico;
    #[Validate('required')]
    public $nombre_trabajo_academico;
    #[Validate('nullable')]
    public $descripcion_trabajo_academico;
    #[Validate('required')]
    public $fecha_inicio_trabajo_academico;
    #[Validate('required')]
    public $fecha_fin_trabajo_academico;
    #[Validate('required')]
    public $hora_inicio_trabajo_academico;
    #[Validate('required')]
    public $hora_fin_trabajo_academico;
    #[Validate(['archivos_trabajo_academico.*' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt,jpg,jpeg,png|max:4096'])]
    public $archivos_trabajo_academico = [];
    public $nombre_archivo_trabajo_academico = [];
    public $iteration = 1;

    protected $listeners = ['abrir-modal-trabajo-editar' => 'abrir_modal_editar_trabajo'];

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $es_docente = false;
    public $es_docente_invitado = false;
    public $tipo_vista;

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;



    /**
     * Abrir modal para agregar trabajo académico
     */
    public function abrir_modal_agregar_trabajo()
    {
        $this->limpiar_modal();
        $this->modo = 1;
        $this->titulo_modal = 'Agregar Trabajo Académico';
        $this->accion_modal = 'Agregar';
    }


    /**
     * Abrir modal para editar trabajo académico
     */
    public function abrir_modal_editar_trabajo($id_trabajo_academico)
    {
        $this->limpiar_modal();
        $this->modo = 0;
        $this->titulo_modal = 'Editar Trabajo Académico';
        $this->accion_modal = 'Editar';

        $this->editar_trabajo_academico = TrabajoAcademico::find($id_trabajo_academico);
        $this->nombre_trabajo_academico = $this->editar_trabajo_academico->titulo_trabajo_academico;
        $this->descripcion_trabajo_academico = $this->editar_trabajo_academico->descripcion_trabajo_academico;
        $this->fecha_inicio_trabajo_academico = date('Y-m-d', strtotime($this->editar_trabajo_academico->fecha_inicio_trabajo_academico));
        $this->fecha_fin_trabajo_academico = date('Y-m-d', strtotime($this->editar_trabajo_academico->fecha_fin_trabajo_academico));
        $this->hora_inicio_trabajo_academico = date('H:i', strtotime($this->editar_trabajo_academico->fecha_inicio_trabajo_academico));
        $this->hora_fin_trabajo_academico = date('H:i', strtotime($this->editar_trabajo_academico->fecha_fin_trabajo_academico));
    }


    /**
     * Subir archivo del trabajo académico para guardar archivos
     */
    public function subir_archivo_trabajo()
    {
        $carpetas = obtener_ruta_base($this->id_gestion_aula);
        array_push($carpetas, 'trabajos-academicos');

        $nombres_bd = [];

        foreach ($this->archivos_trabajo_academico as $archivo) {
            $nombre_archivo_trabajo = null;
            $extension_archivo = strtolower($archivo->getClientOriginalExtension());

            $extensiones_permitidas = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png'];

            if (!in_array($extension_archivo, $extensiones_permitidas)) {
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
     * Eliminar archivo del trabajo académico en caso de rollback
     */
    public function eliminar_archivo_trabajo($nombres_archivos)
    {
        foreach ($nombres_archivos as $ruta) {
            eliminar_archivo($ruta);
        }
    }


    /**
     * Guardar trabajo académico
     */
    public function guardar_trabajo()
    {
        $this->validate([
            'nombre_trabajo_academico' => 'required',
            'fecha_inicio_trabajo_academico' => 'required|before_or_equal:fecha_fin_trabajo_academico|date',
            'fecha_fin_trabajo_academico' => 'required|after_or_equal:fecha_inicio_trabajo_academico|date',
            'hora_inicio_trabajo_academico' => 'required|date_format:H:i|before_or_equal:hora_fin_trabajo_academico',
            'hora_fin_trabajo_academico' => 'required|date_format:H:i|after_or_equal:hora_inicio_trabajo_academico',
            'archivos_trabajo_academico.*' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt,jpg,jpeg,png|max:4096',
        ]);

        try {
            DB::beginTransaction();

            if (!empty($this->archivos_trabajo_academico)) {
                $nombres_bd = $this->subir_archivo_trabajo();
            }

            if ($this->modo === 1) // Modo agregar
            {
                $trabajo_academico = new TrabajoAcademico();
                $trabajo_academico->titulo_trabajo_academico = $this->nombre_trabajo_academico;
                $trabajo_academico->descripcion_trabajo_academico = $this->descripcion_trabajo_academico;
                $trabajo_academico->fecha_inicio_trabajo_academico = $this->fecha_inicio_trabajo_academico . ' ' . $this->hora_inicio_trabajo_academico;
                $trabajo_academico->fecha_fin_trabajo_academico = $this->fecha_fin_trabajo_academico . ' ' . $this->hora_fin_trabajo_academico;
                $trabajo_academico->id_gestion_aula = $this->id_gestion_aula;
                $trabajo_academico->save();

                // Guardar el archivos
                if (count($nombres_bd) > 0) {
                    foreach ($nombres_bd as $nombre_bd) {
                        $archivo_docente = new ArchivoDocente();
                        $archivo_docente->nombre_archivo_docente = $this->nombre_archivo_trabajo_academico[array_search($nombre_bd, $nombres_bd)];
                        $archivo_docente->id_trabajo_academico = $trabajo_academico->id_trabajo_academico;
                        $archivo_docente->archivo_docente = $nombre_bd;
                        $archivo_docente->save();
                    }
                }
            } else { // Modo editar
                $trabajo_academico = TrabajoAcademico::find($this->editar_trabajo_academico->id_trabajo_academico);
                $trabajo_academico->titulo_trabajo_academico = $this->nombre_trabajo_academico;
                $trabajo_academico->descripcion_trabajo_academico = $this->descripcion_trabajo_academico;
                $trabajo_academico->fecha_inicio_trabajo_academico = $this->fecha_inicio_trabajo_academico . ' ' . $this->hora_inicio_trabajo_academico;
                $trabajo_academico->fecha_fin_trabajo_academico = $this->fecha_fin_trabajo_academico . ' ' . $this->hora_fin_trabajo_academico;
                $trabajo_academico->save();

                // Guardar el archivos
                if (count($this->archivos_trabajo_academico) > 0) {
                    foreach ($nombres_bd as $nombre_bd) {
                        $archivo_docente = new ArchivoDocente();
                        $archivo_docente->nombre_archivo_docente = $this->nombre_archivo_trabajo_academico[array_search($nombre_bd, $nombres_bd)];
                        $archivo_docente->id_trabajo_academico = $trabajo_academico->id_trabajo_academico;
                        $archivo_docente->archivo_docente = $nombre_bd;
                        $archivo_docente->save();
                    }
                }
            }

            DB::commit();

            if (count($this->archivos_trabajo_academico) <= 0) {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El trabajo académico se ha guardado correctamente, pero no se ha subido ningún archivo',
                    type: 'info'
                );
            } else {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El trabajo académico se ha guardado correctamente',
                    type: 'success'
                );
            }

            $this->cerrar_modal();
            $this->limpiar_modal();
            // Evento para actualizar la lista de trabajos académicos
            $this->dispatch('actualizar-trabajos-academicos');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($nombres_bd)) {
                $this->eliminar_archivo_trabajo($nombres_bd);
            }

            dd($e);
            // $this->cerrar_modal();
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
    public function cerrar_modal($modal = '#modal-trabajo-academico')
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
        $this->titulo_modal = 'Agregar Trabajo Académico';
        $this->accion_modal = 'Agregar';
        $this->reset([
            'nombre_trabajo_academico',
            'descripcion_trabajo_academico',
            'fecha_inicio_trabajo_academico',
            'fecha_fin_trabajo_academico',
            'hora_inicio_trabajo_academico',
            'hora_fin_trabajo_academico',
            'archivos_trabajo_academico'
        ]);
        $this->iteration++;

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Obtener datos para mostrar en el componente page-header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = 'Trabajos Académicos';

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


    /**
     * Mostrar los trabajos académicos del curso
     */
    public function mostrar_trabajos()
    {
        $this->trabajos_academicos = TrabajoAcademico::where('id_gestion_aula', $this->id_gestion_aula)
            ->orderBy('fecha_inicio_trabajo_academico', 'DESC')
            ->get();
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
        $this->mostrar_trabajos();
    }

    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.index');
    }
}
