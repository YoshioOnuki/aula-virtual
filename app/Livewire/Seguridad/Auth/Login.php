<?php

namespace App\Livewire\Seguridad\Auth;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
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

        $usuario = Usuario::activo()->correo($this->correo)->first();
        if($usuario && Hash::check($this->contrasenia, $usuario->contrasenia_usuario)){
            Auth::login($usuario, false);
            $usuario->ultima_accion_usuario = now();
            $usuario->id_accion_usuario = 1;
            $usuario->save();
            return redirect()->intended(route('inicio'));
        }
        $this->addError('correo', 'Estas credenciales son incorrectas.');
        $this->addError('contrasenia', 'Estas credenciales son incorrectas.');
    }

    public function render()
    {
        return view('livewire.seguridad.auth.login');
    }
}
