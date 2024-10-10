<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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


    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $appends = [
        'usuario_auditoria',
        'accion_auditoria',
    ];

    /**
     * Los atributos que deben ocultarse.
     *
     * @var array
     */
    protected $hidden = [
        'id_registro_auditoria',
        'id_usuario',
        'ip_auditoria',
        'id_accion',
    ];

    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $casts = [
        'registro_auditoria' => 'collection',
        'usuario_auditoria' => 'string',
        'accion_auditoria' => 'string',
        'valor_anterior_auditoria' => 'json',
        'valor_nuevo_auditoria' => 'json',
        'fecha_auditoria' => 'datetime',
    ];


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;


    /**
     * Retorna accion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accion()
    {
        return $this->belongsTo(Accion::class, 'id_accion');
    }

    /**
     * Retorna usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }


    /**
     * Get the registro_auditoria attribute.
     *
     * @return collection
     */
    public function getRegistroAuditoriaAttribute(): Collection
    {
        return $this->tabla_auditoria::find($this->id_registro_auditoria);
    }

    /**
     * Get the usuario_auditoria attribute.
     *
     * @return string
     */
    public function getUsuarioAuditoriaAttribute(): string
    {
        return $this->usuario->nombre_usuario;
    }

    /**
     * Get the accion_auditoria attribute.
     *
     * @return string
     */
    public function getAccionAuditoriaAttribute(): string
    {
        return $this->accion->nombre_accion;
    }

    /**
     * Get the valor_anterior_auditoria attribute.
     *
     * @return json
     */
    public function getValorAnteriorAuditoriaAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the valor_nuevo_auditoria attribute.
     *
     * @return json
     */
    public function getValorNuevoAuditoriaAttribute($value)
    {
        return json_decode($value);
    }
}
