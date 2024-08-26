<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAulaUsuario;
use App\Models\LinkClase;
use App\Models\Presentacion;
use App\Models\Usuario;
use DOMDocument;
use DOMElement;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Detalle extends Component
{

    public $id_gestion_aula_usuario_hash;
    public $id_gestion_aula_usuario;
    public $curso;
    public $gestion_aula_usuario;

    public $nombre_curso;
    public $grupo_gestion_aula;
    public $orientaciones_generales_bool = true;
    public $orientaciones_generales;
    public $link_clase;
    public $link_clase_bool = true;

    public $cargando = true;
    public $cargando_orientaciones = true;


    public $usuario;
    public $id_usuario_hash;

    // Variables para el modal de Link de Clase
    public $modo_link_clase = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_link_clase = 'Agregar Link de Clase';
    public $accion_estado_link_clase = 'Agregar';
    #[Validate('required|url')]
    public $nombre_link_clase;

    // Variables para el modal de Orientaciones
    public $modo_orientaciones = 1; // Modo 1 = Agregar / 0 = Editar
    public $titulo_orientaciones = 'Agregar Orientaciones';
    public $accion_estado_orientaciones = 'Agregar';
    #[Validate('required')]
    public $descripcion_orientaciones;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, si es alumno o docente

    // Variables para page-header
    public $titulo_page_header = 'Detalle';
    public $titulo_pasos_header = 'Detalle';
    public $links_page_header = [];
    public $regresar_page_header;


    /* =============== FUNCIONES PARA EL MODAL DE LINK DE CURSO Y ORIENTACIONES - AGREGAR Y EDITAR =============== */
        public function abrir_modal_link_clase()
        {
            $this->limpiar_modal();
            if(!$this->link_clase)
            {
                $this->modo_link_clase = 1; // Agregar
                $this->titulo_link_clase = 'Agregar Link de Clase';
                $this->accion_estado_link_clase = 'Agregar';
            }else{
                $this->modo_link_clase = 0; // Editar
                $this->titulo_link_clase = 'Editar Link de Clase';
                $this->accion_estado_link_clase = 'Editar';
                $this->nombre_link_clase = $this->link_clase->nombre_link_clase;
            }

            $this->dispatch(
                'modal',
                modal: '#modal-link-clase',
                action: 'show'
            );
        }

        public function abrir_modal_orientaciones()
        {
            $this->limpiar_modal();

            if(!$this->orientaciones_generales)
            {
                $this->modo_orientaciones = 1; // Agregar
                $this->titulo_orientaciones = 'Agregar Orientaciones';
                $this->accion_estado_orientaciones = 'Agregar';
            }else{
                $this->modo_orientaciones = 0; // Editar
                $this->titulo_orientaciones = 'Editar Orientaciones';
                $this->accion_estado_orientaciones = 'Editar';
                $this->descripcion_orientaciones = $this->orientaciones_generales->descripcion_presentacion;
            }

            $this->dispatch(
                'modal',
                modal: '#modal-orientaciones',
                action: 'show'
            );
        }

        public function guardar_link_clase()
        {
            $this->nombre_link_clase = limpiar_cadena($this->nombre_link_clase);
            $this->validate([
                'nombre_link_clase' => 'required|url'
            ]);


            try
            {
                DB::beginTransaction();

                $id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

                if($this->modo_link_clase === 1) // Agregar
                {
                    $link_clase = new LinkClase();
                    $link_clase->nombre_link_clase = $this->nombre_link_clase;
                    $link_clase->id_gestion_aula = $id_gestion_aula;
                    $link_clase->save();
                    $this->link_clase_bool = true;
                    $this->dispatch('actualizar_datos_curso');
                }else{ // Editar
                    $link_clase = LinkClase::find($this->link_clase->id_link_clase);
                    $link_clase->nombre_link_clase = $this->nombre_link_clase;
                    $link_clase->save();
                }

                DB::commit();

                $this->cerrar_modal();

                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El Link de Clase se ha guardado correctamente',
                    type: 'success'
                );

            } catch (\Exception $e) {
                DB::rollBack();
                // dd($e);
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Ha ocurrido un error al guardar el Link de Clase',
                    type: 'error'
                );
            }
        }

        public function guardar_orientaciones()
        {
            if ($this->descripcion_orientaciones === '<p><br></p>' || $this->descripcion_orientaciones === '<h1><br></h1>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_orientaciones === '<p></p>' || $this->descripcion_orientaciones === '' ||
            $this->descripcion_orientaciones === null) {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El campo de Orientaciones Generales es obligatorio',
                    type: 'error'
                );
                return;
            } elseif ($this->orientaciones_generales !== null &&
                $this->orientaciones_generales->descripcion_presentacion === $this->descripcion_orientaciones) {
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'No se han realizado cambios en las Orientaciones Generales',
                    type: 'info'
                );
                $this->cerrar_modal();
                return;
            }

            try
            {
                DB::beginTransaction();

                $id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

                $mensaje = $this->texto_orientaciones();
                // Eliminar archivos de la descripción anterior
                if ($this->orientaciones_generales) {
                    $deletedFiles = $this->eliminar_archivos($this->orientaciones_generales->descripcion_presentacion);
                }

                if($this->modo_orientaciones === 1) // Agregar
                {
                    $orientaciones = new Presentacion();
                    $orientaciones->descripcion_presentacion = $mensaje;
                    $orientaciones->id_gestion_aula = $id_gestion_aula;
                    $orientaciones->save();
                    $this->orientaciones_generales_bool = true;
                }else{ // Editar
                    $orientaciones = Presentacion::find($this->orientaciones_generales->id_presentacion);
                    $orientaciones->descripcion_presentacion = $mensaje;
                    $orientaciones->save();
                }

                DB::commit();

                $this->cerrar_modal();

                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Las Orientaciones Generales se han guardado correctamente',
                    type: 'success'
                );
                $this->mount($this->id_usuario_hash, $this->tipo_vista, $this->id_gestion_aula_usuario_hash);

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                // Eliminar archivos subidos recientemente $mensaje, si hubo un error
                if ($mensaje) {
                    $errorFiles = $this->eliminar_archivos($mensaje);
                }
                $this->cerrar_modal();
                $this->mount($this->id_usuario_hash, $this->tipo_vista, $this->id_gestion_aula_usuario_hash);

                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Ha ocurrido un error al guardar las Orientaciones Generales',
                    type: 'error'
                );
            }
        }

        public function texto_orientaciones()
        {
            $mensaje = $this->descripcion_orientaciones;
            // dd($mensaje);
            if ($this->modo_orientaciones === 0) {
                $mensaje = preg_replace('/<meta http-equiv="Content-Type" content="text\/html; charset=utf-8">/', '', $mensaje);
                $mensaje = preg_replace('/\n/', '', $mensaje);
            }
            $mensaje = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $mensaje . '</body></html>';

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            // Convertir y cargar el contenido HTML en UTF-8
            $utf8Html = mb_convert_encoding($mensaje, 'HTML-ENTITIES', 'UTF-8');
            @$dom->loadHTML($utf8Html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $img) {
                if ($img instanceof DOMElement) {// Verificar si es una instancia de DOMElement
                    $data = $img->getAttribute('src');
                    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                        // Extraer el tipo de imagen y los datos
                        $data = substr($data, strpos($data, ',') + 1);
                        // Asegurarse de que sea un tipo de imagen válido (png, jpg, jpeg, gif)
                        $type = strtolower($type[1]);

                        // Si no es un tipo de imagen válido, continúa con la siguiente iteración
                        $data = base64_decode($data);
                        if ($data === false) {
                            continue;
                        }

                        // Directorio donde se guardará la imagen
                        $directory = public_path('archivos/Posgrado/media/orientaciones/');

                        // Verifica si el directorio existe, si no, lo crea
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }

                        $filename = time() . uniqid() . ".$type";
                        $filePath = $directory . $filename;

                        // Guarda el archivo en la ruta especificada
                        file_put_contents($filePath, $data);

                        // Actualizar la fuente de la imagen en el HTML
                        $img->removeAttribute('src');
                        $img->setAttribute('src', asset('archivos/Posgrado/media/orientaciones/' . $filename));
                    }
                }
            }

            $m = $dom->saveHTML();
            return $m;
        }

        public function eliminar_archivos($descripcion)
        {
            $mensaje = $descripcion;

            // Parsear el contenido HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($mensaje, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Encontrar todas las etiquetas <img>
            $images = $dom->getElementsByTagName('img');
            $deletedFiles = [];

            foreach ($images as $img) {
                if ($img instanceof DOMElement) {
                    $src = $img->getAttribute('src');

                    // Si la ruta es relativa, obtén la parte que corresponde al archivo
                    if (strpos($src, asset('archivos/Posgrado/media/orientaciones/')) !== false) {
                        $filePath = str_replace(asset(''), '', $src);
                        $absolutePath = public_path($filePath);

                        // Verificar si el archivo existe y eliminarlo
                        if (file_exists($absolutePath)) {
                            unlink($absolutePath);
                            $deletedFiles[] = $absolutePath;
                        }
                    }
                }
            }

            return $deletedFiles; // Retornar los archivos eliminados para referencia
        }

        public function cerrar_modal()
        {
            $this->limpiar_modal();
            $this->dispatch(
                'modal',
                modal: '#modal-link-clase',
                action: 'hide'
            );
            $this->dispatch(
                'modal',
                modal: '#modal-orientaciones',
                action: 'hide'
            );
        }

        public function limpiar_modal()
        {
            // Variables de link de clase
            $this->modo_link_clase = 1;
            $this->titulo_link_clase = 'Agregar Link de Clase';
            $this->accion_estado_link_clase = 'Agregar';

            // Variables de Orientaciones
            $this->modo_orientaciones = 1;
            $this->titulo_orientaciones = 'Agregar Orientaciones';
            $this->accion_estado_orientaciones = 'Agregar';

            $this->reset([
                'descripcion_orientaciones',
                'nombre_link_clase'
            ]);
            // Limpiar el texarea de las orientaciones, ya que estoy usando un editor de texto
            $this->dispatch('limpiar-orientaciones');

            // Reiniciar errores
            $this->resetErrorBag();
        }
    /* ======================================================================= */


    /* =============== OBTENER DATOS PARA LA VISTA =============== */
        public function mostrar_orientaciones()
        {
            $gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'presentacion' => function ($query) {
                            $query->select('id_presentacion', 'descripcion_presentacion', 'id_gestion_aula');
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

            if ($gestion_aula_usuario->gestionAula->presentacion) {
                $this->orientaciones_generales = $gestion_aula_usuario->gestionAula->presentacion;
                $this->orientaciones_generales_bool = true;
            }else{
                $this->orientaciones_generales = null;
                $this->orientaciones_generales_bool = false;
            }
        }

        public function mostrar_titulo_curso()
        {
            $gestion_aula_usuario = GestionAulaUsuario::with([
                'gestionAula' => function ($query) {
                    $query->with([
                        'curso' => function ($query) {
                            $query->select('id_curso', 'nombre_curso');
                        }
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

            if ($gestion_aula_usuario) {
                $this->nombre_curso = $gestion_aula_usuario->gestionAula->curso->nombre_curso;
                $this->grupo_gestion_aula = $gestion_aula_usuario->gestionAula->grupo_gestion_aula;
            }
        }

        public function obtener_link_clase()
        {
            $this->gestion_aula_usuario = GestionAulaUsuario::with([
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
                        'linkClase' => function ($query) {
                            $query->select('id_link_clase', 'id_gestion_aula', 'nombre_link_clase');
                        },
                    ])->select('id_gestion_aula', 'grupo_gestion_aula', 'id_curso');
                }
            ])->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario)->first();

            if($this->gestion_aula_usuario->gestionAula->linkClase)
            {
                $this->link_clase = $this->gestion_aula_usuario->gestionAula->linkClase;
                $this->link_clase_bool = true;
            }else{
                $this->link_clase = null;
                $this->link_clase_bool = false;
            }

        }
    /* =========================================================== */


    /* =============== CARGA DE ORIENTACIONES =============== */
        public function load_orientaciones()
        {
            $this->mostrar_orientaciones();
            $this->cargando_orientaciones = false;
        }
    /* ====================================================== */


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            $this->titulo_pasos_header = 'Detalle';
            $this->titulo_page_header = $this->nombre_curso . ' GRUPO ' . $this->grupo_gestion_aula;

            // Regresar
            if($this->tipo_vista === 'cursos')
            {
                $this->regresar_page_header = [
                    'route' => 'cursos',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos']
                ];
            } else {
                $this->regresar_page_header = [
                    'route' => 'carga-academica',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica']
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
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos']
                ];
            } else {
                $this->links_page_header[] = [
                    'name' => 'Carga Académica',
                    'route' => 'carga-academica',
                    'params' => ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica']
                ];
            }

        }
    /* ==================================================================================== */


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->tipo_vista = $tipo_vista;

        $this->id_gestion_aula_usuario_hash = $id_curso;

        $id_gestion_aula_usuario = Hashids::decode($id_curso);
        $this->id_gestion_aula_usuario = $id_gestion_aula_usuario[0];

        $this->mostrar_titulo_curso();

        $this->id_usuario_hash = $id_usuario;
        $usuario = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($usuario[0]);

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);
        if ($usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }

        $this->obtener_datos_page_header();
        $this->mostrar_orientaciones();
        $this->descripcion_orientaciones = $this->orientaciones_generales->descripcion_presentacion ?? '';

    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
