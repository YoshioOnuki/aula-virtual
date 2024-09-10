<?php

namespace App\Livewire\Seguridad\Auth;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
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

    public $tiempo_restante = null;
    public $estado_bloqueo = false;
    protected $max_intentos = 5; // Máximos intentos permitidos
    protected $tiempo_bloqueo = 1; // Tiempo de bloqueo en minutos


    public function iniciar_sesion()
    {
        $this->validate();

        $key = request()->ip();

        if ($this->tiempo_restante === null) {
            $usuario = Usuario::activo()->correo($this->correo)->first();

            if ($usuario && Hash::check($this->contrasenia, $usuario->contrasenia_usuario)) {
                Auth::login($usuario, false);
                $usuario->ultima_accion_usuario = now();
                $usuario->id_accion_usuario = 1;
                $usuario->save();

                RateLimiter::clear($key); // Limpiar intentos después del inicio de sesión exitoso

                return redirect()->intended(route('inicio'));
            }

            RateLimiter::hit($key, $this->tiempo_bloqueo * 10); // Incrementar el contador de intentos fallidos

            $this->addError('correo', 'Estas credenciales son incorrectas.');
            $this->addError('contrasenia', 'Estas credenciales son incorrectas.');

            if ($this->tiempo_restante === null && RateLimiter::tooManyAttempts($key, $this->max_intentos)) {
                $this->tiempo_restante = RateLimiter::availableIn($key);
                $this->estado_bloqueo = true;
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'Demasiados intentos. Por favor, intente nuevamente en . ' . $this->tiempo_bloqueo . ' minutos.',
                    type: 'error'
                );
            } else {
                $this->estado_bloqueo = false;
            }
        }
    }


    public function update_tiempo_restante()
    {
        $key = request()->ip();

        if (RateLimiter::tooManyAttempts($key, $this->max_intentos)) {
            $this->tiempo_restante = RateLimiter::availableIn($key);
            $this->estado_bloqueo = true;
        } else if ($this->estado_bloqueo === true && $this->tiempo_restante !== null) {
            $this->tiempo_restante = null;
            // Manda un dispatch para cambiar el estado del bloqueo
            $this->dispatch('estado-bloqueo');
        }
    }


    public function cerrar_bloqueo()
    {
        $this->estado_bloqueo = false;
    }

    public function mount()
    {
        $this->update_tiempo_restante();
        // RateLimiter::clear(request()->ip());
    }


    public function render()
    {
        return view('livewire.seguridad.auth.login');
    }
}
