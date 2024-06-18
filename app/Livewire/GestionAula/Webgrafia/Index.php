<?php

namespace App\Livewire\GestionAula\Webgrafia;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.gestion-aula.webgrafia.index');
    }
}
