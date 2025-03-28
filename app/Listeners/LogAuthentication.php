<?php

namespace App\Listeners;

use App\Jobs\RegistrarAuditoriaJob;
use App\Models\Usuario;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class LogAuthentication
{


    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $usuario = Usuario::find(Auth::user()->id_usuario);
        if ($usuario->esRol('ADMINISTRADOR') && !config('settings.admin_sesion_auditoria')) {
            return;
        } else if ($usuario->esRol('ADMINISTRADOR') && !config('settings.sesion_auditoria')) {
            return;
        }

        // Verificar si la auditoría está habilitada para Iniciar sesión y Cerrar sesión
        if (config('settings.sesion_auditoria')) {

            $accion = ($event instanceof Login) ? 'Iniciar sesión' : 'Cerrar sesión';
            // dd($event);

            // Obtener la dominio de la URL
            $url = Request::fullUrl();
            $url = parse_url($url);
            $url['path'] = ($event instanceof Login) ? '/login' : '/logout';
            $url = $url['scheme'] . '://' . $url['host'] . $url['path'];

            if ($event instanceof \Illuminate\Auth\Events\Logout || $event instanceof \Illuminate\Auth\Events\Login) {
                // Registrar en la tabla de auditoría
                $agent = new Agent();

                $datosAuditoria = [
                    'accion' => $accion,// Acción
                    'tabla' => null,// Tabla
                    'id_registro' => null,// ID del registro
                    'valor_anterior' => null,// Valor anterior
                    'valor_nuevo' => null,// Valor nuevo
                    'id_usuario' => $event->user->id_usuario,// ID del usuario
                    'ip' => Request::ip(),// IP
                    'navegador' => $agent->browser() . ' ' . $agent->version($agent->browser()),
                    'so' => $agent->platform() . ' ' . $agent->version($agent->platform()),
                    'user_agent' => Request::header('User-Agent'),// User Agent
                    'url' => $url,// URL
                    'fecha' => now(),// Fecha
                ];


                RegistrarAuditoriaJob::dispatch($datosAuditoria);
            }

        }
    }


}
