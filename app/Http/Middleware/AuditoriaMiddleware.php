<?php

namespace App\Http\Middleware;

use App\Jobs\RegistrarAuditoriaJob;
use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class AuditoriaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $usuario = Usuario::find(Auth::user()->id_usuario);
            if ($usuario->esRol('ADMINISTRADOR') && !config('settings.admin_acceso_auditoria')) {
                return $next($request);
            } else if ($usuario->esRol('ADMINISTRADOR') && !config('settings.acceso_auditoria')) {
                return $next($request);
            }

            // Verificar si la auditoría está habilitada para el acceso
            if (config('settings.acceso_auditoria')) {

                $agent = new Agent();

                $datosAuditoria = [
                    'accion' => 'Acceder',// Acción
                    'tabla' => null,// Tabla
                    'id_registro' => null,// ID del registro
                    'valor_anterior' => null,// Valor anterior
                    'valor_nuevo' => null,// Valor nuevo
                    'id_usuario' => Auth::user()->id_usuario,// ID del usuario
                    'ip' => $request->ip(),// IP
                    'navegador' => $agent->browser() . ' ' . $agent->version($agent->browser()),// Navegador
                    'so' => $agent->platform() . ' ' . $agent->version($agent->platform()),// Sistema Operativo
                    'user_agent' => $request->header('User-Agent'),// User Agent
                    'url' => $request->fullUrl(),// URL
                    'fecha' => now(),// Fecha
                ];

                RegistrarAuditoriaJob::dispatch($datosAuditoria);
            }
        }

        return $next($request);
    }
}
