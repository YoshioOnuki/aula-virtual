<?php

namespace App\Livewire\Seguridad\Auth;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Login - Aula Virtual')]
class Login extends Component
{

    #[Validate('required|email')]
    public $correo;
    #[Validate('required')]
    public $contrasenia;

    public function iniciar_sesion()
    {
        $this->validate();

        $usuario = Usuario::where('correo_usuario', $this->correo)->first();
        if($usuario && Hash::check($this->contrasenia, $usuario->contrasenia_usuario)){
            auth()->login($usuario, false);
            return redirect()->route('inicio');
        }
        $this->addError('correo', 'Estas credenciales son incorrectas.');
        $this->addError('contrasenia', 'Estas credenciales son incorrectas.');
    }

    public function render()
    {
        return view('livewire.seguridad.auth.login');
    }
}
