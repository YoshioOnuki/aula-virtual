<?php

namespace App\Traits;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

trait UsuarioTrait
{
    // Método para obtener el usuario autenticado desde la sesión
    public function obtenerUsuarioAutenticado()
    {
        $usuario = Auth::user();
        return Usuario::find($usuario->id_usuario);
    }

    // Método para obtener el ID del curso desde la URL (o cualquier otro dato de la URL)
    public function obtenerIdUsuarioDesdeUrlCodificado()
    {
        // Usar los parámetros de la ruta
        return Route::current()->parameter('id_usuario');
    }

    // Método para obtener el ID del curso desde la URL (o cualquier otro dato de la URL)
    public function obtenerIdUsuarioDesdeUrlDecodificado()
    {
        $id_usuario = $this->obtenerIdUsuarioDesdeUrlCodificado();
        // Decodificar el ID
        return Hashids::decode($id_usuario)[0];
    }

    // Método para obtener el usuario del curso en el que está actualmente
    public function obtenerUsuarioDelCurso()
    {
        $id_usuario = $this->obtenerIdUsuarioDesdeUrlDecodificado();
        return Usuario::find($id_usuario);
    }

    // Método para obtener el ID del curso desde la URL (o cualquier otro dato de la URL)
    public function obtenerIdCursoDesdeUrlCodificado()
    {
        // Usar los parámetros de la ruta
        return Route::current()->parameter('id_curso');
    }

    // Método para obtener el ID del curso desde la URL (o cualquier otro dato de la URL)
    public function obtenerIdCursoDesdeUrlDecodificado()
    {
        $id_curso = $this->obtenerIdCursoDesdeUrlCodificado();
        // Decodificar el ID
        return Hashids::decode($id_curso)[0];
    }

    // Método para obtener verificar si el usuario del curso esta en modo invitado
    public function verificarUsuarioInvitado()
    {
        $id_gestion_aula = $this->obtenerIdCursoDesdeUrlDecodificado();
        $tipo_vista = Route::current()->parameter('tipo_vista');
        $usuario = $this->obtenerUsuarioDelCurso();

        return $usuario->esDocenteInvitadoAula($id_gestion_aula) && $tipo_vista === 'carga-academica' ? true : false;
    }
}
