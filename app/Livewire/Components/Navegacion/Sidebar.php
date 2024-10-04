<?php

namespace App\Livewire\Components\Navegacion;

use App\Traits\UsuarioTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    use UsuarioTrait;

    public $usuario;
    public $persona;
    public $nombre;


    /**
     * Método para cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $this->usuario = $this->obtenerUsuarioAutenticado();
        $this->persona = $this->usuario->persona;
        $this->nombre = strtoupper($this->persona->soloPrimerosNombres);
    }


    public function render()
    {
        // // Clave de caché única por usuario y vista
        // $cacheKey = 'sidebar_' . $this->usuario->id_usuario;

        // // Guardar el contenido en caché durante 5 minutos
        // $usuarioData = Cache::remember($cacheKey, 300, function () {
        //     // Lógica para recuperar la información que necesitas mostrar
        //     return view('livewire.components.curso.admin-info-usuario', [
        //         'usuario' => $this->usuario,
        //         'tipo_vista' => $this->tipo_vista,
        //     ])->render();
        // });

        // return $usuarioData;

        return view('livewire.components.navegacion.sidebar');
    }
}
