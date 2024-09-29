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
    public $vista_curso = "cursos";
    public $vista_carga = "carga-academica";

    public $ruta_vista;


    public function mostrar_cursos()
    {
        $cursos = GestionAula::with(['gestionAulaUsuario', 'gestionAulaUsuario.rol'])
            ->whereHas('gestionAulaUsuario', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->where('estado_gestion_aula_usuario', 1)
                    ->whereHas('rol', function ($query) {
                        $query->where('nombre_rol', 'ALUMNO');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $this->cursos = $cursos->sortBy('gestionAula.curso.nombre_curso');

        $carga_academica = GestionAula::with(['gestionAulaUsuario', 'gestionAulaUsuario.rol'])
            ->whereHas('gestionAulaUsuario', function ($query) {
                $query->where('id_usuario', $this->usuario->id_usuario)
                    ->where('estado_gestion_aula_usuario', 1)
                    ->whereHas('rol', function ($query) {
                        $query->whereIn('nombre_rol', ['DOCENTE', 'DOCENTE INVITADO']);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $this->carga_academica = $carga_academica->sortBy('gestionAula.curso.nombre_curso');

    }


    public function mount()
    {
        $user = Auth::user();
        $this->usuario = Usuario::find($user->id_usuario);
        $this->ruta_vista = request()->route()->getName();

        $this->mostrar_cursos();
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
