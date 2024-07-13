<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAulaUsuario;
use App\Models\LinkClase;
use App\Models\Presentacion;
use App\Models\Usuario;
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
        $this->descripcion_orientaciones = limpiar_cadena($this->descripcion_orientaciones);
        $this->validate([
            'descripcion_orientaciones' => 'required'
        ]);


        try
        {
            DB::beginTransaction();

            $id_gestion_aula = GestionAulaUsuario::find($this->id_gestion_aula_usuario)->id_gestion_aula;

            if($this->modo_orientaciones === 1) // Agregar
            {
                $orientaciones = new Presentacion();
                $orientaciones->descripcion_presentacion = $this->descripcion_orientaciones;
                $orientaciones->id_gestion_aula = $id_gestion_aula;
                $orientaciones->save();
                $this->orientaciones_generales_bool = true;
            }else{ // Editar
                $orientaciones = Presentacion::find($this->orientaciones_generales->id_presentacion);
                $orientaciones->descripcion_presentacion = $this->descripcion_orientaciones;
                $orientaciones->save();
            }

            DB::commit();

            $this->cerrar_modal();

            $this->dispatch(
                'toast-basico',
                mensaje: 'Las Orientaciones Generales se han guardado correctamente',
                type: 'success'
            );

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
        // Reiniciar errores
        $this->resetErrorBag();
    }


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


    /* =============== CARGA DE ORIENTACIONES =============== */
    public function load_orientaciones()
    {
        $this->mostrar_orientaciones();
        $this->cargando_orientaciones = false;
    }


    /* =============== REDIRECCIONAR A OTRAS VISTAS =============== */
    public function redireccionar_silabus($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }
        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.silabus', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.silabus', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_recursos($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }
        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.recursos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.recursos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_foro($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.foro', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.foro', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_asistencia($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.asistencia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.asistencia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_trabajo_academico($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.trabajo-academico', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.trabajo-academico', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_webgrafia($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

        if($this->tipo_vista === 'cursos'){
            return redirect()->route('cursos.detalle.webgrafia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
        }else{
            return redirect()->route('carga-academica.detalle.webgrafia', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
        }
    }

    public function redireccionar_alumnos($id)
    {
        $id_curso = Hashids::encode($id);
        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

        return redirect()->route('carga-academica.detalle.alumnos', ['id_usuario' => $this->id_usuario_hash, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
    }


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
    public function obtener_datos_page_header()
    {
        $this->titulo_pasos_header = 'Detalle';
        $this->titulo_page_header = $this->nombre_curso . ' GRUPO ' . $this->grupo_gestion_aula;

        if($this->modo_admin)
        {
            session(['modo_admin' => true]);
        }else{
            session()->forget('modo_admin');
        }

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
        if (session('modo_admin') || $usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }else{
            session()->forget('modo_admin');
        }

        $this->obtener_datos_page_header();

    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
