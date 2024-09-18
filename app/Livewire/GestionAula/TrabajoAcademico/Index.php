<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\ArchivoDocente;
use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $id_gestion_aula;
    public $gestion_aula_usuario;
    public $ruta_pagina;
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

    protected $listeners = ['abrir-modal-editar' => 'abrir_modal_editar_trabajo'];

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;

    /* =============== FUNCIONES PARA EL MODAL DE TRABAJO ACADEMICO - AGREGAR =============== */
        public function abrir_modal_agregar_trabajo()
        {
            $this->limpiar_modal();
            $this->modo = 1;
            $this->titulo_modal = 'Agregar Trabajo Académico';
            $this->accion_modal = 'Agregar';

            $this->dispatch(
                'modal',
                modal: '#modal-trabajo-academico',
                action: 'show'
            );
        }

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

            $this->dispatch(
                'modal',
                modal: '#modal-trabajo-academico',
                action: 'show'
            );
        }

        public function subir_archivo_trabajo()
        {
            $carpetas = obtener_ruta_base($this->id_gestion_aula_usuario);
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

        public function eliminar_archivo_trabajo($nombres_archivos)
        {
            foreach ($nombres_archivos as $ruta) {
                eliminar_archivo($ruta);
            }
        }

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

                if($this->modo === 1)// Modo agregar
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
                }else{// Modo editar
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
                }else{
                    $this->dispatch(
                        'toast-basico',
                        mensaje: 'El trabajo académico se ha guardado correctamente',
                        type: 'success'
                    );
                }

                $this->cerrar_modal();
                // Evento para actualizar la lista de trabajos académicos
                $this->dispatch('actualizar-trabajos-academicos');

            } catch (\Exception $e) {
                DB::rollBack();

                if (isset($nombres_bd)) {
                    $this->eliminar_archivo_trabajo($nombres_bd);
                }

                dd($e);
                $this->cerrar_modal();
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Ha ocurrido un error al guardar el trabajo academico',
                    type: 'error'
                );
            }
        }

        public function cerrar_modal()
        {
            $this->limpiar_modal();
            $this->dispatch(
                'modal',
                modal: '#modal-trabajo-academico',
                action: 'hide'
            );
        }

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
    /* ====================================================================================== */


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_page_header = 'Trabajos Académicos';

            // Regresar
            if ($this->tipo_vista === 'cursos') {
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

            // Links --> Detalle del curso o carga académica
            if ($this->tipo_vista === 'cursos') {
                $this->links_page_header[] = [
                    'name' => 'Detalle',
                    'route' => 'cursos.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Detalle',
                    'route' => 'carga-academica.detalle',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            }
        }
    /* ==================================================================================== */


        /* =============== OBTENER DATOS PARA MOSTRAR LOS TRABAJOS =============== */
        public function mostrar_trabajos()
        {
            $gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'curso' => function ($query) {
                            $query->with([
                                'ciclo',
                                'planEstudio',
                                'programa' => function ($query) {
                                    $query->with([
                                        'facultad',
                                        'tipoPrograma'
                                    ])->select('id_programa', 'nombre_programa', 'mencion_programa', 'id_tipo_programa', 'id_facultad');
                                }
                            ])->select('id_curso', 'codigo_curso', 'nombre_curso', 'creditos_curso', 'horas_lectivas_curso', 'id_programa', 'id_plan_estudio', 'id_ciclo');
                        },
                        'trabajoAcademico' => function ($query) {
                            $query->with([
                                'archivoDocente' => function ($query) {
                                    $query->get();
                                },
                                'trabajoAcademicoAlumno' => function ($query) {
                                    $query->with([
                                        'archivoAlumno' => function ($query) {
                                            $query->get();
                                        },
                                        'estadoTrabajoAcademico' => function ($query) {
                                            $query->first();
                                        },
                                        'comentarioTrabajoAcademico' => function ($query) {
                                            $query->get();
                                        }
                                    ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->get();
                                },
                            ])->orderBy('fecha_inicio_trabajo_academico', 'DESC')
                                ->get();
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)
                ->first();

            if ($gestion_aula_usuario) {
                $this->trabajos_academicos = $gestion_aula_usuario->gestionAula->trabajoAcademico;
            }
        }
    /* ======================================================================= */

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

        if ($usuario_sesion->esRol('ADMINISTRADOR')) {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();

        $this->ruta_pagina = request()->route()->getName();

        $this->mostrar_trabajos();

    }

    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.index');
    }
}
