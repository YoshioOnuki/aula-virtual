<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use App\Models\ArchivoDocente;
use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Vinkla\Hashids\Facades\Hashids;

class Detalle extends Component
{

    use WithFileUploads;

    public $id_usuario_hash;
    public $usuario;

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $id_gestion_aula;
    public $gestion_aula_usuario;
    public $trabajo_academico;

    // Variables para el modal de Trabajo Académico
    public $modo = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_modal = 'Agregar Entrega de Trabajo Académico';
    public $accion_modal = 'Agregar';
    #[Validate('nullable')]
    public $descripcion_trabajo_academico_alumno;
    #[Validate(['archivos_trabajo_alumno.*' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt,jpg,jpeg,png|max:4096'])]
    public $archivos_trabajo_alumno = [];
    public $iteration = 1;


    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador

    // Variables para page-header
    public $titulo_page_header = 'Trabajo académico';
    public $links_page_header = [];
    public $regresar_page_header;

    public $tipo_vista;


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_page_header = 'Detalle del Trabajo Académico';

            // Regresar
            if ($this->tipo_vista === 'cursos') {
                $this->regresar_page_header = [
                    'route' => 'cursos.detalle.trabajo-academico',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->regresar_page_header = [
                    'route' => 'carga-academica.detalle.trabajo-academico',
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

            // Links --> Trabajos académicos
            if ($this->tipo_vista === 'cursos') {
                $this->links_page_header[] = [
                    'name' => 'Trabajos académicos',
                    'route' => 'cursos.detalle.trabajo-academico',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Trabajos académicos',
                    'route' => 'carga-academica.detalle.trabajo-academico',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_usuario_hash]
                ];
            }
        }
    /* ==================================================================================== */


    /* =============== FUNCIONES PARA EL MODAL DE DETALLE DE TRABAJO ACADEMICO - CREAR, EDITAR Y DESCARGAR =============== */
        public function abrir_modal_entrega_trabajo()
        {
            $this->limpiar_modal();

            $this->modo = 1;
            $this->titulo_modal = 'Agregar Entrega de Trabajo Académico';
            $this->accion_modal = 'Agregar';

            $this->dispatch(
                'modal',
                modal: '#modal-entrega',
                action: 'show'
            );

        }

        public function subir_archivo_entrega()
        {
            $carpetas = obtener_ruta_base($this->id_gestion_aula_usuario);
            array_push($carpetas, 'trabajos-academicos');

            $nombres_bd = [];

            foreach ($this->archivos_trabajo_alumno as $archivo) {
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

        public function eliminar_archivo_entrega($nombres_archivos)
        {
            foreach ($nombres_archivos as $ruta) {
                eliminar_archivo($ruta);
            }
        }

        // public function guardar_entrega_trabajo()
        // {
        //     $this->validate([
        //         'descripcion_trabajo_academico_alumno' => 'required',
        //         'archivos_trabajo_alumno.*' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,txt,jpg,jpeg,png|max:4096',
        //     ]);

        //     try {
        //         DB::beginTransaction();

        //         if (!empty($this->archivos_trabajo_academico)) {
        //             $nombres_bd = $this->subir_archivo_trabajo();
        //         }

        //         if($this->modo === 1)// Modo agregar
        //         {
        //             $trabajo_academico = new TrabajoAcademico();
        //             $trabajo_academico->titulo_trabajo_academico = $this->nombre_trabajo_academico;
        //             $trabajo_academico->descripcion_trabajo_academico = $this->descripcion_trabajo_academico;
        //             $trabajo_academico->fecha_inicio_trabajo_academico = $this->fecha_inicio_trabajo_academico . ' ' . $this->hora_inicio_trabajo_academico;
        //             $trabajo_academico->fecha_fin_trabajo_academico = $this->fecha_fin_trabajo_academico . ' ' . $this->hora_fin_trabajo_academico;
        //             $trabajo_academico->id_gestion_aula = $this->id_gestion_aula;
        //             $trabajo_academico->save();

        //             // Guardar el archivos
        //             if (count($nombres_bd) > 0) {
        //                 foreach ($nombres_bd as $nombre_bd) {
        //                     $archivo_docente = new ArchivoDocente();
        //                     $archivo_docente->nombre_archivo_docente = $this->nombre_archivo_trabajo_academico[array_search($nombre_bd, $nombres_bd)];
        //                     $archivo_docente->id_trabajo_academico = $trabajo_academico->id_trabajo_academico;
        //                     $archivo_docente->archivo_docente = $nombre_bd;
        //                     $archivo_docente->save();
        //                 }
        //             }
        //         }else{// Modo editar
        //             $trabajo_academico = TrabajoAcademico::find($this->editar_trabajo_academico->id_trabajo_academico);
        //             $trabajo_academico->titulo_trabajo_academico = $this->nombre_trabajo_academico;
        //             $trabajo_academico->descripcion_trabajo_academico = $this->descripcion_trabajo_academico;
        //             $trabajo_academico->fecha_inicio_trabajo_academico = $this->fecha_inicio_trabajo_academico . ' ' . $this->hora_inicio_trabajo_academico;
        //             $trabajo_academico->fecha_fin_trabajo_academico = $this->fecha_fin_trabajo_academico . ' ' . $this->hora_fin_trabajo_academico;
        //             $trabajo_academico->save();

        //             // Guardar el archivos
        //             if (count($this->archivos_trabajo_academico) > 0) {
        //                 foreach ($nombres_bd as $nombre_bd) {
        //                     $archivo_docente = new ArchivoDocente();
        //                     $archivo_docente->nombre_archivo_docente = $this->nombre_archivo_trabajo_academico[array_search($nombre_bd, $nombres_bd)];
        //                     $archivo_docente->id_trabajo_academico = $trabajo_academico->id_trabajo_academico;
        //                     $archivo_docente->archivo_docente = $nombre_bd;
        //                     $archivo_docente->save();
        //                 }
        //             }
        //         }

        //         DB::commit();

        //         if (count($this->archivos_trabajo_academico) <= 0) {
        //             $this->dispatch(
        //                 'toast-basico',
        //                 mensaje: 'El trabajo académico se ha guardado correctamente, pero no se ha subido ningún archivo',
        //                 type: 'success'
        //             );
        //         }else{
        //             $this->dispatch(
        //                 'toast-basico',
        //                 mensaje: 'El trabajo académico se ha guardado correctamente',
        //                 type: 'success'
        //             );
        //         }

        //         $this->cargando_trabajos = true;
        //         $this->cerrar_modal();
        //         $this->load_trabajos_llamar();

        //     } catch (\Exception $e) {
        //         DB::rollBack();

        //         if (isset($nombres_bd)) {
        //             $this->eliminar_archivo_trabajo($nombres_bd);
        //         }

        //         dd($e);
        //         $this->cerrar_modal();
        //         $this->dispatch(
        //             'toast-basico',
        //             mensaje: 'Ha ocurrido un error al guardar el Trabajo Academico',
        //             type: 'error'
        //         );
        //     }
        // }

        public function texto_descripcion_trabajo()
        {
            $mensaje = $this->descripcion_trabajo_academico_alumno;
            $mensaje = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $mensaje . '</body></html>';

            return $mensaje;
        }

        public function cerrar_modal()
        {
            $this->limpiar_modal();
            $this->dispatch(
                'modal',
                modal: '#modal-entrega',
                action: 'hide'
            );
        }

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

        public function descargar_archivo(ArchivoDocente $archivo)
        {
            $ruta = $archivo->archivo_docente;
            return response()->download($ruta, $archivo->nombre_archivo_docente.'.'.pathinfo($ruta, PATHINFO_EXTENSION));

        }
    /* ==================================================================================== */


    public function mount($id_usuario, $tipo_vista, $id_curso, $id_trabajo_academico)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_trabajo_academico = Hashids::decode($id_trabajo_academico);
        $this->trabajo_academico = TrabajoAcademico::with('archivoDocente')->find($id_trabajo_academico[0]);
        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

        $this->id_usuario_hash = $id_usuario;
        $id_usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id_usuario[0]);

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);

        if ($usuario_sesion->esRol('ADMINISTRADOR')) {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();
    }


    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.detalle');
    }
}
