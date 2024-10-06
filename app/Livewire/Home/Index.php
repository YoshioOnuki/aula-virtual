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

    public function mostrar_cursos()
    {
        $cursos = GestionAula::with(['curso'])
            ->whereHas('gestionAulaAlumno', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(true)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->cursos = $cursos->sortBy('curso.nombre_curso');

        $cursos_finalizados = GestionAula::with(['curso'])
            ->whereHas('gestionAulaAlumno', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(false)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->cursos_finalizados = $cursos_finalizados->sortBy('curso.nombre_curso');


        $carga_academica = GestionAula::with(['curso'])
            ->whereHas('gestionAulaDocente', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(true)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->carga_academica = $carga_academica->sortBy('curso.nombre_curso');

        $carga_academica_finalizada = GestionAula::with(['curso'])
            ->whereHas('gestionAulaDocente', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->estado(true);
            })
            ->estado(true)
            ->enCurso(false)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->carga_academica_finalizada = $carga_academica_finalizada->sortBy('curso.nombre_curso');
    }


    /**
     * Funsiones para la vista Dashboard
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


    public function mount()
    {
        $user = Auth::user();
        $this->usuario = Usuario::find($user->id_usuario);

        if (!$this->usuario->esRol('ADMINISTRADOR')) {
            $this->mostrar_cursos();
        }

        $this->acceso_auditoria = config('settings.acceso_auditoria');
    }

    public function render()
    {
        $autoridades_model = Autoridad::with('facultad', 'cargo')->activo()->orderBy('id_cargo')
            ->get();

        if ($this->usuario->esRol('ADMINISTRADOR'))
        {
            return view('livewire.home.dashboard');
        } else {
            return view('livewire.home.index', [
                'autoridades_model' => $autoridades_model
            ]);
        }

    }
}
