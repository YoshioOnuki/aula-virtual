<?php

namespace App\Livewire\Components\Foro;

use App\Models\Foro;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

#[Lazy(isolate: false)]
class CardForo extends Component
{
    public $tipo_vista;
    public $usuario;
    public $id_usuario_hash;
    public $id_gestion_aula;
    public $foro;

    protected $listeners = ['actualizar-foros' => '$actualizar_foros'];


    /**
     * Abrir modal para editar foro
     */
    public function abrir_modal($id_foro)
    {
        $this->dispatch('abrir-modal-foro-editar', $id_foro);
    }


    /**
     * Actualizar foros despues de registrar o editar
     */
    public function actualizar_foros()
    {
        $this->mount($this->tipo_vista, $this->usuario, $this->id_gestion_aula, $this->foro);
    }


    /**
     * Placeholder para mostrar mientras se cargan los datos
     */
    public function placeholder()
    {
        return <<<'HTML'
        <div class="col-12">
            <div class="card placeholder-glow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-5">
                        <div class="placeholder col-6" style="height: 1.5rem;"></div>
                        <div class="placeholder"></div>
                    </div>
                    <div class="d-none d-sm-block">
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                        <div class="col-12"></div>
                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                        </div>
                    </div>
                    <div class=" d-flex justify-content-end">
                        @if ($tipo_vista === 'carga-academica' &&
                        $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                        <a href="#" tabindex="-1"
                            class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block"
                            aria-hidden="true"></a>
                        <a href="#" tabindex="-1"
                            class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon"
                            aria-hidden="true"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }


    public function mount($tipo_vista, $usuario, $id_curso, $foro)
    {
        $this->id_usuario_hash = Hashids::encode($usuario->id_usuario);
        $this->usuario = $usuario;
        $this->tipo_vista = $tipo_vista;
        $this->id_gestion_aula = $id_curso;

        if ($this->usuario->esDocente($this->id_gestion_aula)) {
            $this->foro = Foro::find($foro->id_foro);
        }else{
            // $this->foro = Foro::with([
            //     'foroRespuesta' => function ($query) {
            //         $query->orderBy('created_at', 'asc')
            //             ->where('id_gestion_aula_usuario', $this->id_gestion_aula_usuario);
            //     }
            // ])->find($foro->id_foro);
        }
    }


    public function render()
    {
        return view('livewire.components.foro.card-foro');
    }
}
