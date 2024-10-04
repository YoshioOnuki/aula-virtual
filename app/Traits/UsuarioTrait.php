<?php

namespace App\Traits;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

trait UsuarioTrait
{
    // Método para obtener el usuario autenticado desde la sesión
    public function obtener_usuario_autenticado()
    {
        $usuario = Auth::user();
        return Usuario::find($usuario->id_usuario);
    }

    // Método para obtener el ID del curso desde la URL codificado
    public function obtener_id_usuario_curso_codificado()
    {
        // Usar los parámetros de la ruta
        return Route::current()->parameter('id_usuario');
    }

    // Método para obtener el ID del curso desde la URL decodificado
    public function obtener_id_usuario_curso()
    {
        $id_usuario = $this->obtener_id_usuario_curso_codificado();
        // Decodificar el ID
        return Hashids::decode($id_usuario)[0];
    }

    // Método para obtener el usuario del curso en el que está actualmente
    public function obtener_usuario_del_curso()
    {
        $id_usuario = $this->obtener_id_usuario_url_decodificado();
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
