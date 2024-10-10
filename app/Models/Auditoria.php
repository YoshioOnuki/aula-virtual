<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditoria';
    protected $primaryKey = 'id_auditoria';

    protected $fillable = [
        'id_auditoria',
        'id_accion',
        'tabla_auditoria',
        'id_registro_auditoria',
        'valor_anterior_auditoria',
        'valor_nuevo_auditoria',
        'id_usuario',
        'ip_auditoria',
        'navegador_auditoria',
        'so_auditoria',
        'user_agent_auditoria',
        'url_auditoria',
        'fecha_auditoria',
    ];

    public function accion()
    {
        return $this->belongsTo(Accion::class, 'id_accion');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public $timestamps = false;

    protected $casts = [
        'fecha_auditoria' => 'datetime',
    ];

    protected $hidden = [
        'id_usuario',
        'ip_auditoria',
        'id_accion',
    ];

    protected $appends = [
        'usuario_auditoria',
        'accion_auditoria',
    ];

    public function getUsuarioAuditoriaAttribute()
    {
        return $this->usuario->nombre_usuario;
    }

    public function getAccionAuditoriaAttribute()
    {
        return $this->accion->nombre_accion;
    }

    public function getValorAnteriorAuditoriaAttribute($value)
    {
        return json_decode($value);
    }

    public function getValorNuevoAuditoriaAttribute($value)
    {
        return json_decode($value);
    }



}
