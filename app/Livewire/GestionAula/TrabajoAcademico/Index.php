<?php

namespace App\Livewire\GestionAula\TrabajoAcademico;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.gestion-aula.trabajo-academico.index');
    }
}
