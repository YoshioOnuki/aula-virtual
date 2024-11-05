<?php

namespace App\Livewire\Home;

use App\Models\Autoridad;
use App\Models\GestionAula;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public $usuario;
    public $cursos;
    public $carga_academica;
    public $cursos_finalizados;
    public $carga_academica_finalizada;
    public $vista_curso = "cursos";
    public $vista_carga = "carga-academica";

    public $tipo_vista_curso = "cursos";
    public $tipo_vista_carga = "carga-academica";


    /**
     * Variables para la vista Dashboard
     */
    public $acceso_auditoria;
    public $cantidad_cursos;
    public $cantidad_cursos_en_curso;
    public $cantidad_usuarios;
    public $cantidad_usuarios_nuevos;
    public $cantidad_alumnos;
    public $cantidad_alumnos_nuevos;
    public $cantidad_docentes;
    public $cantidad_docentes_nuevos;

    public $almacenamiento_total;
    public $almacenamiento_trabajos_academicos;
    public $almacenamiento_silabus;
    public $almacenamiento_recursos;
    public $almacenamiento_foros;
    public $almacenamiento_orientaciones;
    public $porcentaje_trabajos_academicos;
    public $porcentaje_silabus;
    public $porcentaje_recursos;
    public $porcentaje_foros;
    public $porcentaje_orientaciones;


    /**
     * Obtener los cursos y carga académica del usuario
     */
    public function mostrar_cursos()
    {
        $cursos = GestionAula::with(['curso'])
            ->whereHas('gestionAulaAlumno', function ($query) {
                $query->usuario($this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(true)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->cursos = $cursos->sortBy('curso.nombre_curso');

        $cursos_finalizados = GestionAula::with(['curso'])
            ->whereHas('gestionAulaAlumno', function ($query) {
                $query->usuario($this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(false)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->cursos_finalizados = $cursos_finalizados->sortBy('curso.nombre_curso');


        $carga_academica = GestionAula::with(['curso'])
            ->whereHas('gestionAulaDocente', function ($query) {
                $query->usuario($this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(true)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->carga_academica = $carga_academica->sortBy('curso.nombre_curso');

        $carga_academica_finalizada = GestionAula::with(['curso'])
            ->whereHas('gestionAulaDocente', function ($query) {
                $query->usuario($this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(false)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->carga_academica_finalizada = $carga_academica_finalizada->sortBy('curso.nombre_curso');
    }


    /**
     * Función para cambiar accesos a la auditoría
     */
    public function estado_acceso_auditoria()
    {
        $this->acceso_auditoria = !$this->acceso_auditoria;

        config(['settings.acceso_auditoria' => $this->acceso_auditoria]);

        // Cambiar el estado de la variable en el archivo de configuración
        // $config = config('settings');
        // $config['acceso_auditoria'] = $this->acceso_auditoria;
        // $config = var_export($config, true);
        // $config = str_replace("array (", "config([", $config);
        // $config = str_replace(")", "]);", $config);
        // $config = "<?php\n\n" . $config;
        // file_put_contents(config_path('settings.php'), $config);

    }


    /**
     * Función para mostrar cantidad de cursos, usuarios, alumnos y docentes
     */
    public function mostrar_cantidades()
    {
        $this->cantidad_cursos = GestionAula::count();
        $this->cantidad_cursos_en_curso = GestionAula::enCurso(true)->count();
        $this->cantidad_usuarios = Usuario::count();
        $this->cantidad_usuarios_nuevos = Usuario::whereYear('created_at', now()->year)->count();
        $this->cantidad_alumnos = Usuario::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })->count();
        $this->cantidad_alumnos_nuevos = Usuario::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('nombre_rol', 'ALUMNO');
            })->whereYear('created_at', now()->year)->count();
        $this->cantidad_docentes = Usuario::with('roles')
            ->whereHas('roles', function ($query) {
            $query->where('nombre_rol', 'DOCENTE');
        })->count();
        $this->cantidad_docentes_nuevos = Usuario::with('roles')
            ->whereHas('roles', function ($query) {
            $query->where('nombre_rol', 'DOCENTE');
        })->whereYear('created_at',now()->year)->count();
    }


    /**
     * Función para calcular el almacenamiento de archivos
     */
    public function calcular_almacenamiento()
    {
        // Calcular el tamaño de trabajo académicos
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/media/editor-texto/trabajos-academicos-alumnos/');
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/maestria/trabajos-academicos-alumnos/');
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/doctorado/trabajos-academicos-alumnos/');
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/media/editor-texto/trabajos-academicos/');
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/maestria/trabajos-academicos/');
        $this->almacenamiento_trabajos_academicos += tamano_carpeta('archivos/posgrado/doctorado/trabajos-academicos/');

        $this->almacenamiento_silabus = tamano_carpeta('archivos/posgrado/maestria/silabus/');
        $this->almacenamiento_recursos = tamano_carpeta('archivos/posgrado/maestria/recursos/');
        $this->almacenamiento_foros = tamano_carpeta('archivos/posgrado/media/editor-texto/foros/');
        $this->almacenamiento_orientaciones = tamano_carpeta('archivos/posgrado/media/editor-texto/orientaciones/');

        $this->almacenamiento_total = $this->almacenamiento_trabajos_academicos +
            $this->almacenamiento_silabus +
            $this->almacenamiento_recursos +
            $this->almacenamiento_foros +
            $this->almacenamiento_orientaciones;

        $this->porcentaje_trabajos_academicos = porcentaje_uso($this->almacenamiento_total, $this->almacenamiento_trabajos_academicos);
        $this->porcentaje_silabus = porcentaje_uso($this->almacenamiento_total, $this->almacenamiento_silabus);
        $this->porcentaje_recursos = porcentaje_uso($this->almacenamiento_total, $this->almacenamiento_recursos);
        $this->porcentaje_foros = porcentaje_uso($this->almacenamiento_total, $this->almacenamiento_foros);
        $this->porcentaje_orientaciones = porcentaje_uso($this->almacenamiento_total, $this->almacenamiento_orientaciones);

        $this->almacenamiento_total = format_bytes($this->almacenamiento_total);
        $this->almacenamiento_trabajos_academicos = format_bytes($this->almacenamiento_trabajos_academicos);
        $this->almacenamiento_silabus = format_bytes($this->almacenamiento_silabus);
        $this->almacenamiento_recursos = format_bytes($this->almacenamiento_recursos);
        $this->almacenamiento_foros = format_bytes($this->almacenamiento_foros);
        $this->almacenamiento_orientaciones = format_bytes($this->almacenamiento_orientaciones);

    }


    public function mount()
    {
        $user = Auth::user();
        $this->usuario = Usuario::find($user->id_usuario);

        if ($this->usuario->esRol('ADMINISTRADOR')) {
            $this->mostrar_cantidades();
            $this->calcular_almacenamiento();
        } else {
            $this->mostrar_cursos();
        }

        $this->acceso_auditoria = config('settings.acceso_auditoria');
    }


    public function render()
    {
        if ($this->usuario->esRol('ADMINISTRADOR'))
        {
            return view('livewire.home.dashboard');
        } else {
            $autoridades_model = Autoridad::with('facultad', 'cargo')->activo()->orderBy('id_cargo')
            ->get();

            return view('livewire.home.index', [
                'autoridades_model' => $autoridades_model
            ]);
        }

    }
}
