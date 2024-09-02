<?php

namespace App\Livewire\GestionAula\Curso;

use App\Models\AsistenciaAlumno;
use App\Models\ForoRespuesta;
use App\Models\GestionAulaUsuario;
use App\Models\TrabajoAcademico;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public $id_usuario_hash;
    public $usuario;
    public $cursos;
    public $favorito;
    public $numero_progreso = array();
    public $numero_progreso_realizados = array();
    public $progreso = array();
    public $foto_docente = array();

    public $cargando = true;

    public $modo_admin = false;// Modo admin, para saber si se esta en modo administrador
    public $tipo_vista; // Tipo de vista, para saber si es alumno o docente

    // Variables para page-header
    public $titulo_page_header;
    public $links_page_header = [];
    public $regresar_page_header;


    public function curso_favorito($id)
    {
        // usleep(500000);
        $gest_aula_usua = GestionAulaUsuario::find($id);
        if ($gest_aula_usua->favorito_gestion_aula_usuario == 0) {
            $gest_aula_usua->favorito_gestion_aula_usuario = 1;
        } else {
            $gest_aula_usua->favorito_gestion_aula_usuario = 0;
        }
        $gest_aula_usua->save();
    }

    public function redirigir_curso_detalle($id)
    {
        $docente  = GestionAulaUsuario::with('usuario.persona')
            ->where('id_gestion_aula', $id)
            ->whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'DOCENTE');
            })
            ->first();
        if($docente) {
            $gestion_aula_usuario = GestionAulaUsuario::where('id_gestion_aula', $id)
                ->where('id_usuario', $this->usuario->id_usuario)
                ->first();

            $id_curso = Hashids::encode($gestion_aula_usuario->id_gestion_aula_usuario);
            $id_usuario = Hashids::encode($this->usuario->id_usuario);

            $usuario_sesion = Usuario::find(auth()->user()->id_usuario);
            if ($usuario_sesion->esRol('ADMINISTRADOR'))
            {
                $this->modo_admin = true;
            }

            if($this->tipo_vista === 'cursos')
            {
                return redirect()->route('cursos.detalle', ['id_usuario' => $id_usuario, 'tipo_vista' => 'cursos', 'id_curso' => $id_curso]);
            } else {
                return redirect()->route('carga-academica.detalle', ['id_usuario' => $id_usuario, 'tipo_vista' => 'carga-academica', 'id_curso' => $id_curso]);
            }
        } else {

            $this->dispatch(
                'toast-basico',
                mensaje: 'No se puede acceder al curso, no tiene docente asignado',
                type: 'error'
            );
        }
    }

    public function calcular_progreso()
    {
        $this->calcular_trabajo_academico();
        $this->calcular_foros();
        $this->calcular_asistencia();
    }

    public function calcular_trabajo_academico()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->trabajoAcademico->count() > 0) {
                $trabajos = $curso->gestionAula->trabajoAcademico->count();
                $trabajos_realizados = 0;


                $trabajos_realizados = TrabajoAcademico::Join('trabajo_academico_alumno', 'trabajo_academico.id_trabajo_academico', '=', 'trabajo_academico_alumno.id_trabajo_academico')
                    ->where('trabajo_academico.id_gestion_aula', $curso->gestionAula->id_gestion_aula)
                    ->where('trabajo_academico_alumno.id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)
                    ->where('trabajo_academico_alumno.id_estado_trabajo_academico', 2)
                    ->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] = $trabajos;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] = $trabajos_realizados;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($trabajos_realizados / $trabajos) * 100);
            }
        }
    }

    public function calcular_foros()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->foro->count() > 0) {
                $foros = $curso->gestionAula->foro->count();
                $foros_realizados = 0;

                $foros_realizados = ForoRespuesta::Join('foro', 'foro.id_foro', '=', 'foro_respuesta.id_foro')
                    ->where('foro_respuesta.id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)
                    ->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] += $foros;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] += $foros_realizados;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] / $this->numero_progreso[$curso->id_gestion_aula_usuario]) * 100);
            }
        }
    }

    public function calcular_asistencia()
    {
        foreach ($this->cursos as $curso) {
            if ($curso->gestionAula->asistencia->count() > 0) {
                $asistencias = $curso->gestionAula->asistencia->count();
                $asistencias_realizadas = 0;

                $asistencias_realizadas = AsistenciaAlumno::where('id_gestion_aula_usuario', $curso->id_gestion_aula_usuario)->count();

                $this->numero_progreso[$curso->id_gestion_aula_usuario] += $asistencias;
                $this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] += $asistencias_realizadas;
                $this->progreso[$curso->id_gestion_aula_usuario] = round(($this->numero_progreso_realizados[$curso->id_gestion_aula_usuario] / $this->numero_progreso[$curso->id_gestion_aula_usuario]) * 100);
            }
        }
    }

    public function mostrar_cursos()
    {
        if($this->tipo_vista === 'cursos')
        {
            $cursos = GestionAulaUsuario::with(['gestionAula.curso', 'rol'])
                ->where('id_usuario', $this->usuario->id_usuario)
                ->where('estado_gestion_aula_usuario', 1)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'ALUMNO');
                })
                ->orderBy('favorito_gestion_aula_usuario', 'desc')
                ->get();

            $favoritos = $cursos->where('favorito_gestion_aula_usuario', 1)
                ->sortBy('gestionAula.curso.nombre_curso');

            $noFavoritos = $cursos->where('favorito_gestion_aula_usuario', 0)
                ->sortBy('gestionAula.curso.nombre_curso');

            $this->cursos = $favoritos->concat($noFavoritos);

        } else {
                $cursos = GestionAulaUsuario::with(['gestionAula.curso', 'rol'])
                    ->where('id_usuario', $this->usuario->id_usuario)
                    ->where('estado_gestion_aula_usuario', 1)
                    ->whereHas('rol', function ($query) {
                        $query->whereIn('nombre_rol', ['DOCENTE', 'DOCENTE INVITADO']);
                    })
                    ->orderBy('favorito_gestion_aula_usuario', 'desc')
                    ->get();

            $favoritos = $cursos->where('favorito_gestion_aula_usuario', 1)
                ->sortBy('gestionAula.curso.nombre_curso');

            $noFavoritos = $cursos->where('favorito_gestion_aula_usuario', 0)
                ->sortBy('gestionAula.curso.nombre_curso');

            $this->cursos = $favoritos->concat($noFavoritos);

        }
    }

    public function mostrar_foto_docente()
    {
        foreach ($this->cursos as $curso) {
            // Sacar el docente del curso desde la gestion aula usuario
            $docente = GestionAulaUsuario::with('usuario.persona')
                ->where('id_gestion_aula', $curso->gestionAula->id_gestion_aula)
                ->whereHas('rol', function ($query) {
                    $query->where('nombre_rol', 'DOCENTE');
                })
                ->first();
                if($docente) {
                    $this->foto_docente[$curso->id_gestion_aula] = $docente->usuario->mostrarFoto('alumno');
                }else{
                    $this->foto_docente[$curso->id_gestion_aula] = '/media/avatar-none.webp';
                }
            }
    }

    public function load_cursos()
    {
        // usleep(100000);
        $this->mostrar_cursos();
        $this->calcular_progreso();
        $this->mostrar_foto_docente();
        $this->cargando = false;
    }


    /* =============== OBTENER DATOS PARA MOSTRAR EL COMPONENTE PAGE HEADER =============== */
        public function obtener_datos_page_header()
        {
            if($this->tipo_vista === 'cursos')
            {
                $this->titulo_page_header = 'Mis Cursos';
            } else {
                $this->titulo_page_header = 'Carga Académica';
            }

            // Regresar

            if($this->modo_admin)
            {
                if($this->tipo_vista === 'cursos')
                {
                    $this->regresar_page_header = [
                        'route' => 'alumnos',
                        'params' => []
                    ];
                } else {
                    $this->regresar_page_header = [
                        'route' => 'docentes',
                        'params' => []
                    ];
                }
            }

            // Links --> Inicio
            $this->links_page_header = [
                [
                    'name' => 'Inicio',
                    'route' => 'inicio',
                    'params' => []
                ]
            ];

        }
    /* ===================================================================================== */


    public function mount($id_usuario, $tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;

        $usuario_sesion = Usuario::find(auth()->user()->id_usuario);

        if ($usuario_sesion->esRol('ADMINISTRADOR'))
        {
            $this->modo_admin = true;
        }

        $this->id_usuario_hash = $id_usuario;
        $id = Hashids::decode($id_usuario);
        $this->usuario = Usuario::find($id[0]);

        $this->obtener_datos_page_header();

    }

    public function render()
    {
        $this->mostrar_cursos();

        return view('livewire.gestion-aula.curso.index');
    }
}
