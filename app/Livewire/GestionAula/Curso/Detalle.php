<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAula;
use App\Models\LinkClase;
use App\Models\Presentacion;
use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Detalle extends Component
{
    use UsuarioTrait;

    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula_hash;
    public $id_gestion_aula;
    public $curso;
    public $ruta_pagina;
    public $opciones_curso = [];

    public $nombre_curso;
    public $grupo_gestion_aula;
    public $orientaciones_generales;
    public $link_clase;

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

    public $modo_admin = false; // Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, si es alumno o docente
    public $es_docente_invitado = false; // Modo invitado, para saber si se esta en modo invitado
    public $cargando = true;
    public $cargando_orientaciones = true;
    public $orientaciones_generales_bool = true;
    public $link_clase_bool = true;

    // Variables para page-header
    public $titulo_page_header = 'Detalle';
    public $links_page_header = [];
    public $regresar_page_header;

    protected $listeners = [
        'abrir-modal-link-clase' => 'abrir_modal_link_clase',
        'abrir-modal-orientaciones' => 'abrir_modal_orientaciones',
    ];


    /**
     * Función para abrir el modal de Link de Clase
     */
    public function abrir_modal_link_clase()
    {
        $this->limpiar_modal();

        if (!$this->link_clase) {
            $this->modo_link_clase = 1; // Agregar
            $this->titulo_link_clase = 'Agregar Link de Clase';
            $this->accion_estado_link_clase = 'Agregar';
        } else {
            $this->modo_link_clase = 0; // Editar
            $this->titulo_link_clase = 'Editar Link de Clase';
            $this->accion_estado_link_clase = 'Editar';
            $this->nombre_link_clase = $this->link_clase->nombre_link_clase;
        }
    }


    /**
     * Función para abrir el modal de Orientaciones
     */
    public function abrir_modal_orientaciones()
    {
        $this->limpiar_modal();

        if (!$this->orientaciones_generales) {
            $this->modo_orientaciones = 1; // Agregar
            $this->titulo_orientaciones = 'Agregar Orientaciones';
            $this->accion_estado_orientaciones = 'Agregar';
        } else {
            $this->modo_orientaciones = 0; // Editar
            $this->titulo_orientaciones = 'Editar Orientaciones';
            $this->accion_estado_orientaciones = 'Editar';
            $this->descripcion_orientaciones = $this->orientaciones_generales->descripcion_presentacion;
        }
    }


    /**
     * Función para guardar el link de la clase
     */
    public function guardar_link_clase()
    {
        $this->nombre_link_clase = limpiar_cadena($this->nombre_link_clase);
        $this->validate([
            'nombre_link_clase' => 'required|url'
        ]);


        try {
            DB::beginTransaction();

            if ($this->modo_link_clase === 1) // Agregar
            {
                $link_clase = new LinkClase();
                $link_clase->nombre_link_clase = $this->nombre_link_clase;
                $link_clase->estado_link_clase = true;
                $link_clase->id_gestion_aula = $this->id_gestion_aula;
                $link_clase->save();
                $this->link_clase_bool = true;
                $this->dispatch('actualizar_datos_curso');
            } else { // Editar
                $link_clase = LinkClase::find($this->link_clase->id_link_clase);
                $link_clase->nombre_link_clase = $this->nombre_link_clase;
                $link_clase->save();
            }

            DB::commit();

            $this->cerrar_modal('#modal-link-clase');
            $this->limpiar_modal();
            $this->obtener_link_clase();
            $this->obtener_opciones_curso();

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


    /**
     * Función para guardar las orientaciones generales
     */
    public function guardar_orientaciones()
    {
        if (
            $this->descripcion_orientaciones === '<p><br></p>' || $this->descripcion_orientaciones === '<h1><br></h1>' ||
            $this->descripcion_orientaciones === '<h2><br></h2>' ||
            $this->descripcion_orientaciones === '<h3><br></h3>' ||
            $this->descripcion_orientaciones === '<h4><br></h4>' ||
            $this->descripcion_orientaciones === '<h5><br></h5>' ||
            $this->descripcion_orientaciones === '<h6><br></h6>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><p><br></p>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h1><br></h1>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h2><br></h2>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h3><br></h3>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h4><br></h4>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h5><br></h5>' ||
            $this->descripcion_orientaciones === '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><h6><br></h6>' ||
            $this->descripcion_orientaciones === '<p></p>' || $this->descripcion_orientaciones === '' ||
            $this->descripcion_orientaciones === null
        ) {
            $this->dispatch(
                'toast-basico',
                mensaje: 'El campo de Orientaciones Generales es obligatorio',
                type: 'error'
            );
            return;
        } elseif (
            $this->orientaciones_generales !== null &&
            $this->orientaciones_generales->descripcion_presentacion === $this->descripcion_orientaciones
        ) {
            $this->dispatch(
                'toast-basico',
                mensaje: 'No se han realizado cambios en las Orientaciones Generales',
                type: 'info'
            );
            $this->cerrar_modal('#modal-orientaciones');
            return;
        }

        try {
            DB::beginTransaction();

            $mensaje = subir_archivo_editor($this->descripcion_orientaciones, 'archivos/posgrado/media/editor-texto/orientaciones/');
            // Eliminar archivos de la descripción anterior
            if ($this->orientaciones_generales) {
                $deletedFiles = eliminar_comparando_archivos_editor($mensaje, $this->orientaciones_generales->descripcion_presentacion, 'archivos/posgrado/media/editor-texto/orientaciones/');
                // dd($deletedFiles);
            }

            if ($this->modo_orientaciones === 1) // Agregar
            {
                $orientaciones = new Presentacion();
                $orientaciones->descripcion_presentacion = $mensaje;
                $orientaciones->id_gestion_aula = $this->id_gestion_aula;
                $orientaciones->save();
                $this->orientaciones_generales_bool = true;
            } else { // Editar
                $orientaciones = Presentacion::find($this->orientaciones_generales->id_presentacion);
                $orientaciones->descripcion_presentacion = $mensaje;
                $orientaciones->save();
            }

            DB::commit();

            $this->cerrar_modal('#modal-orientaciones');
            $this->limpiar_modal();
            $this->mostrar_orientaciones();
            $this->obtener_opciones_curso();
            $this->dispatch('actualizar_link_clase');

            $this->dispatch(
                'toast-basico',
                mensaje: 'Las Orientaciones Generales se han guardado correctamente',
                type: 'success'
            );
            $this->mount($this->id_usuario_hash, $this->tipo_vista, $this->id_gestion_aula_hash);
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ha ocurrido un error al guardar las Orientaciones Generales',
                type: 'error'
            );
        }
    }


    /**
     * Función para cerrar el modal
     */
    public function cerrar_modal($modal)
    {
        $this->dispatch(
            'modal',
            modal: $modal,
            action: 'hide'
        );
    }


    /**
     * Función para limpiar los campos del modal
     */
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

        // Reiniciar errores
        $this->resetErrorBag();
    }


    /**
     * Función para obtener las orientaciones generales o presentación del curso
     */
    public function mostrar_orientaciones()
    {
        $gestion_aula = GestionAula::with('presentacion')->find($this->id_gestion_aula);
        $this->orientaciones_generales = $gestion_aula->presentacion ?? null;
        $this->orientaciones_generales_bool = $gestion_aula->presentacion ? true : false;
    }


    /**
     * Función para obtener el titulo del curso
     */
    public function mostrar_titulo_curso()
    {
        $gestion_aula = GestionAula::with('curso')->find($this->id_gestion_aula);

        if ($gestion_aula) {
            $this->nombre_curso = $gestion_aula->curso->nombre_curso;
            $this->grupo_gestion_aula = $gestion_aula->grupo_gestion_aula;
        }
    }


    /**
     * Función para obtener el link de la clase
     */
    public function obtener_link_clase()
    {
        $gestion_aula = GestionAula::with('linkClase')->find($this->id_gestion_aula);

        $this->link_clase = $gestion_aula->linkClase ?? null;
        $this->link_clase_bool = $gestion_aula->linkClase ? true : false;
    }


    /**
     * Función para obtener opciones del detalle del curso
     */
    public function obtener_opciones_curso()
    {
        // Silabus
        $this->opciones_curso[] = [
            'nombre' => 'Silabus',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.silabus', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.silabus', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-libro-info.webp',
            'notificacion' => false
        ];

        // Recursos
        $this->opciones_curso[] = [
            'nombre' => 'Recursos',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.recursos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.recursos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-carpeta.webp',
            'notificacion' => false
        ];

        // Foro
        $this->opciones_curso[] = [
            'nombre' => 'Foro',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.foro', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.foro', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-foro-discusion.webp',
            'notificacion' => false
        ];

        // Asistencia
        $this->opciones_curso[] = [
            'nombre' => 'Asistencia',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.asistencia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.asistencia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-matricula.webp',
            'notificacion' => false
        ];

        // Trabajos Académicos
        $this->opciones_curso[] = [
            'nombre' => 'Trabajos Académicos',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.trabajo-academico', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.trabajo-academico', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-curso-por-internet.webp',
            'notificacion' => false
        ];

        // Webgrafia
        $this->opciones_curso[] = [
            'nombre' => 'Webgrafía',
            'ruta' => $this->tipo_vista === 'cursos' ?
                route('cursos.detalle.webgrafia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]) :
                route('carga-academica.detalle.webgrafia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
            'icono' => '/media/icons/icon-ubicacion-ip.webp',
            'notificacion' => false
        ];

        if ($this->tipo_vista === 'carga-academica') {
            // Alumnos
            $this->opciones_curso[] = [
                'nombre' => 'Alumnos',
                'ruta' => route('carga-academica.detalle.alumnos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' =>  $this->tipo_vista, 'id_curso' => $this->id_gestion_aula_hash]),
                'icono' => '/media/icons/icon-registro.webp',
                'notificacion' => false
            ];

            // Link de clases
            $this->opciones_curso[] = [
                'nombre' => 'Subir Link de Clases',
                'ruta' => '#modal-link-clase',
                'icono' => '/media/icons/icon-link-hipervinculo.webp',
                'notificacion' => !$this->link_clase_bool ? true : false
            ];

            // Orientaciones Generales
            $this->opciones_curso[] = [
                'nombre' => 'Orientaciones Generales',
                'ruta' => '#modal-orientaciones',
                'icono' => '/media/icons/icon-orien-presentacion2.webp',
                'notificacion' => !$this->orientaciones_generales_bool ? true : false
            ];
        }

    }


    /**
     * Función para obtener los datos del page header
     */
    public function obtener_datos_page_header()
    {
        $this->titulo_page_header = $this->nombre_curso . ' GRUPO ' . $this->grupo_gestion_aula;

        // Regresar
        if ($this->tipo_vista === 'cursos') {
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
        if ($this->tipo_vista === 'cursos') {
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


    public function mount($id_usuario, $tipo_vista, $id_curso)
    {
        $this->id_usuario_hash = $id_usuario;
        $this->usuario = $this->obtener_usuario_del_curso($id_usuario);
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula_hash = $id_curso;
        $this->id_gestion_aula = $this->obtener_id_curso($id_curso);

        $this->mostrar_titulo_curso();

        $this->modo_admin = $this->obtener_usuario_autenticado()->esRol('ADMINISTRADOR');
        $this->es_docente_invitado = $this->verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista);

        $this->obtener_datos_page_header();
        $this->mostrar_orientaciones();
        $this->obtener_link_clase();
        $this->descripcion_orientaciones = $this->orientaciones_generales->descripcion_presentacion ?? '';
        $this->obtener_opciones_curso();

        $this->ruta_pagina = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
