<?php

namespace App\Livewire\Home;

use App\Models\Autoridad;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $autoridades_model = Autoridad::where('estado_autoridad', 1)
            // ->where('id_facultad', null)
            // ->orWhere('id_facultad', 2)
            ->get();

        return view('livewire.home.index', [
            'autoridades_model' => $autoridades_model
        ]);
    }
}
