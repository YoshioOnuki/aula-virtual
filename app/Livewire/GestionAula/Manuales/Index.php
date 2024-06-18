<?php

namespace App\Livewire\GestionAula\Manuales;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.gestion-aula.manuales.index');
    }
}
