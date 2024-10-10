<?php

namespace App\Livewire\Components\Curso;

use App\Models\GestionAula;
use App\Models\GestionAulaDocente;
use App\Models\GestionAulaUsuario;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class InfoDocente extends Component
{
    public $id_gestion_aula;
    public $docente;

    public $tipo_vista; // Para saber que tipo de vista se está mostrando


    public function mostrar_datos_docente()
    {
        if(config('settings.ver_docente_invitado'))
        {
            $this->docente = GestionAulaDocente::with([
                'usuario.persona',
            ])
                ->where('id_gestion_aula', $this->id_gestion_aula)
                ->get();
        }else{
            $this->docente = GestionAulaDocente::with([
                'usuario.persona',
            ])
                ->invitado(false)
                ->where('id_gestion_aula', $this->id_gestion_aula)
                ->get();
        }
    }


    public function placeholder()
    {
        return <<<'HTML'
        <div class="col-12 mb-3">
            <a class="card card-link card-stacked placeholder-glow">
                <div class="card-cover card-cover-blurred text-center">
                    <div class="avatar avatar-xl placeholder {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"></div>
                </div>
                <div class="card-body text-center">
                    <div class="card-title mb-1">
                        <div class="placeholder col-6" style="height: 19.5px"></div>
                    </div>
                    <div class="placeholder bg-secondary col-5" style="height: 17px;"></div>
                    <div class="mt-2">
                        <div class="placeholder {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }} col-3" style="height: 17px;"></div>
                    </div>
                </div>
            </a>
        </div>
        HTML;
    }


    public function mount($id_gestion_aula, $tipo_vista)
    {
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula = $id_gestion_aula;

        $this->mostrar_datos_docente();
    }


    public function render()
    {
        return view('livewire.components.curso.info-docente');
    }
}
