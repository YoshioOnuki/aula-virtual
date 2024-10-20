<?php

namespace App\Traits;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

trait UsuarioTrait
{
    // Método para obtener el usuario autenticado desde la sesión
    public function obtener_usuario_autenticado()
    {
        $usuario = Auth::user();
        return Usuario::find($usuario->id_usuario);
    }

    // Método para obtener el usuario del curso en el que está actualmente
    public function obtener_usuario_del_curso($id_usuario)
    {
        // Decodificar el ID
        $id_usuario = Hashids::decode($id_usuario)[0];
        return Usuario::find($id_usuario);
    }

    // Método para obtener el ID del curso
    public function obtener_id_curso($id_curso)
    {
        // Decodificar el ID
        $id_curso = Hashids::decode($id_curso)[0];
        return $id_curso;
    }

    // Método para obtener verificar si el usuario del curso esta en modo invitado
    public function verificar_usuario_invitado($id_curso, $id_usuario, $tipo_vista)
    {
        $id_gestion_aula = $this->obtener_id_curso($id_curso);
        $usuario = $this->obtener_usuario_del_curso($id_usuario);

        return $usuario->esDocenteInvitado($id_gestion_aula) && $tipo_vista === 'carga-academica' ? true : false;
    }

}
