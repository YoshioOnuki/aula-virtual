<?php

namespace App;

use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use App\GetActionId;
use App\Jobs\RegistrarAuditoriaJob;

trait Auditable
{
    public static function bootAuditable()
    {
        static::creating(function ($model) {
            $agent = new Agent();

            $datosAuditoria = [
                'accion' => 'Registrar', // accion
                'tabla' => $model->getTable(), // tabla
                'id_registro' => $model->getKey(), // id_registro
                'valor_anterior' => null, // valor_anterior
                'valor_nuevo' => json_encode($model->getAttributes()), // valor_nuevo
                'id_usuario' => Auth::user()->id_usuario, // id_usuario
                'ip' => Request::ip(), // ip
                'navegador' => $agent->browser() . ' ' . $agent->version($agent->browser()), // navegador
                'so' => $agent->platform() . ' ' . $agent->version($agent->platform()), // sistema operativo
                'user_agent' => Request::header('User-Agent'), // user_agent
                'url' => Request::fullUrl(), // url
                'fecha' => now(), // fecha
            ];

            RegistrarAuditoriaJob::dispatch($datosAuditoria);
        });

        static::updating(function ($model) {
            $agent = new Agent();

            $datosAuditoria = [
                'accion' => 'Actualizar', // accion
                'tabla' => $model->getTable(), // tabla
                'id_registro' => $model->getKey(), // id_registro
                'valor_anterior' => json_encode($model->getOriginal()), // valor_anterior
                'valor_nuevo' => json_encode($model->getAttributes()), // valor_nuevo
                'id_usuario' => Auth::user()->id_usuario, // id_usuario
                'ip' => Request::ip(), // ip
                'navegador' => $agent->browser() . ' ' . $agent->version($agent->browser()), // navegador
                'so' => $agent->platform() . ' ' . $agent->version($agent->platform()), // sistema operativo
                'user_agent' => Request::header('User-Agent'), // user_agent
                'url' => Request::fullUrl(), // url
                'fecha' => now(), // fecha
            ];

            RegistrarAuditoriaJob::dispatch($datosAuditoria);
        });

        static::deleting(function ($model) {
            $agent = new Agent();

            $datosAuditoria = [
                'accion' => 'Eliminar', // accion
                'tabla' => $model->getTable(), // tabla
                'id_registro' => $model->getKey(), // id_registro
                'valor_anterior' => json_encode($model->getOriginal()), // valor_anterior
                'valor_nuevo' => null, // valor_nuevo
                'id_usuario' => Auth::user()->id_usuario, // id_usuario
                'ip' => Request::ip(), // ip
                'navegador' => $agent->browser() . ' ' . $agent->version($agent->browser()), // navegador
                'so' => $agent->platform() . ' ' . $agent->version($agent->platform()), // sistema operativo
                'user_agent' => Request::header('User-Agent'), // user_agent
                'url' => Request::fullUrl(), // url
                'fecha' => now(), // fecha
            ];

            RegistrarAuditoriaJob::dispatch($datosAuditoria);
        });
    }

}

