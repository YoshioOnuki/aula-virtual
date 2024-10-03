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


    public function mount()
    {
        $user = Auth::user();
        $this->usuario = Usuario::find($user->id_usuario);

        if (!$this->usuario->esRol('ADMINISTRADOR')) {
            $this->mostrar_cursos();
        }
    }

    public function render()
    {
        $autoridades_model = Autoridad::with('facultad', 'cargo')->activo()->orderBy('id_cargo')
            ->get();

        return view('livewire.home.index', [
            'autoridades_model' => $autoridades_model
        ]);
    }
}
