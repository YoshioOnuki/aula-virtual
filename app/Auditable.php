<?php

namespace App;

use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

trait Auditable
{
    public static function bootAuditable()
    {
        static::creating(function ($model) {
            $model->logAudit('Registrar');
        });

        static::updating(function ($model) {
            $model->logAudit('Actualizar');
        });

        static::deleting(function ($model) {
            $model->logAudit('Eliminar');
        });
    }

    public function logAudit($action)
    {
        $user = Auth::user();
        $auditoria = new Auditoria();
        $auditoria->id_accion = $this->getActionId($action); // Obtiene el ID de la acción desde la tabla 'accion'
        $auditoria->tabla_auditoria = $this->getTable(); // Obtiene el nombre de la tabla
        $auditoria->id_registro_auditoria = $this->getKey(); // Obtiene el ID del registro actual

        // Capturar los valores antiguos y nuevos
        $auditoria->valor_anterior_auditoria = json_encode($this->getOriginal()); // Valores antes del cambio, si es una actualización, de lo contrario, será null
        $auditoria->valor_nuevo_auditoria = json_encode($this->getDirty()); // Valores nuevos, si es una actualización, de lo contrario, será null

        // Información del usuario y del dispositivo
        $auditoria->id_usuario = $user ? $user->id_usuario : null;
        $auditoria->ip_auditoria = Request::ip();
        $agent = new Agent();
        $auditoria->navegador_auditoria = $agent->browser() . ' ' . $agent->version($agent->browser());
        $auditoria->so_auditoria = $agent->platform() . ' ' . $agent->version($agent->platform());
        $auditoria->user_agent_auditoria = Request::header('User-Agent');
        $auditoria->fecha_auditoria = now();
        $auditoria->url_auditoria = Request::fullUrl();
        $auditoria->save();
    }

    public function getActionId($action)
    {
        // Método para obtener el ID de la acción desde la tabla 'accion'
        return \App\Models\Accion::where('nombre_accion', $action)->first()->id_accion;
    }
}
