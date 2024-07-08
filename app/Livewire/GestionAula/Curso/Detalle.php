<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\GestionAulaUsuario;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
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
    public $orientaciones_generales = ' ';

    public $cargando = true;
    public $cargando_orientaciones = true;

    public $link_clase;

    public $usuario;
    public $id_usuario_hash;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, si es alumno o docente

    // Variables para page-header
    public $titulo_page_header = 'Detalle';
    public $titulo_pasos_header = 'Detalle';
    public $links_page_header = [];
    public $regresar_page_header;



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
            $this->orientaciones_generales = $gestion_aula_usuario->gestionAula->presentacion->descripcion_presentacion;
        }else{
            $this->orientaciones_generales = '';
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

        $this->link_clase = $this->gestion_aula_usuario->gestionAula->linkClase;

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

        $this->modo_admin = session('modo_admin');

        $this->obtener_datos_page_header();

    }

    public function render()
    {
        return view('livewire.gestion-aula.curso.detalle');
    }
}
