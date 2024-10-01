<?php

namespace App\Jobs;

use App\GetActionId;
use App\Models\Auditoria;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jenssegers\Agent\Agent;
use Symfony\Component\Console\Logger\ConsoleLogger;

class RegistrarAuditoriaJob implements ShouldQueue
{
    use Queueable;
    use GetActionId;

    /**
     * Variables para el registro de auditoria.
     */
    protected $datosAuditoria;

    /**
     * Create a new job instance.
     */
    public function __construct($datos_auditoria)
    {
        $this->datosAuditoria = $datos_auditoria;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $agent = new Agent();

        Auditoria::create([
            'id_accion' => $this->getActionId($this->datosAuditoria['accion']),
            'tabla_auditoria' => $this->datosAuditoria['tabla'],
            'id_registro_auditoria' => $this->datosAuditoria['id_registro'],
            'valor_anterior_auditoria' => $this->datosAuditoria['valor_anterior'],
            'valor_nuevo_auditoria' => $this->datosAuditoria['valor_nuevo'],
            'id_usuario' => $this->datosAuditoria['id_usuario'],
            'ip_auditoria' => $this->datosAuditoria['ip'],
            'navegador_auditoria' => $this->datosAuditoria['navegador'],
            'so_auditoria' => $this->datosAuditoria['so'],
            'user_agent_auditoria' => $this->datosAuditoria['user_agent'],
            'url_auditoria' => $this->datosAuditoria['url'],
            'fecha_auditoria' => $this->datosAuditoria['fecha'],
        ]);

    }
}
