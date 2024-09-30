<?php

namespace App\Listeners;

use App\Models\Auditoria;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        $accion = ($event instanceof Login) ? 'Iniciar sesión' : 'Cerrar sesión';
        $agent = new Agent();

        // Obtener la dominio de la URL
        $url = Request::fullUrl();
        $url = parse_url($url);
        $url['path'] = ($event instanceof Login) ? '/login' : '/logout';
        $url = $url['scheme'] . '://' . $url['host'] . $url['path'];

        if ($event instanceof \Illuminate\Auth\Events\Logout || $event instanceof \Illuminate\Auth\Events\Login) {
            // Registrar en la tabla de auditoría
            Auditoria::create([
                'id_accion' => $this->getActionId($accion),
                'tabla_auditoria' => 'usuario', // O cualquier tabla relevante
                'id_registro_auditoria' => $event->user->id_usuario,
                'valor_anterior_auditoria' => null,
                'valor_nuevo_auditoria' => null,
                'id_usuario' => $event->user->id_usuario,
                'ip_auditoria' => Request::ip(),
                'navegador_auditoria' => $agent->browser() . ' ' . $agent->version($agent->browser()),
                'so_auditoria' => $agent->platform() . ' ' . $agent->version($agent->platform()),
                'user_agent_auditoria' => Request::header('User-Agent'),
                'url_auditoria' => $url,
                'fecha_auditoria' => now(),
            ]);
        }
    }

    public function getActionId($action)
    {
        // Método para obtener el ID de la acción desde la tabla 'accion'
        return \App\Models\Accion::where('nombre_accion', $action)->first()->id_accion;
    }
}
