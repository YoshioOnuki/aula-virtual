<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAsistencia extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'tipo_asistencia';
    protected $primaryKey = 'id_tipo_asistencia';
    protected $fillable = [
        'id_tipo_asistencia',
        'nombre_tipo_asistencia',
        'estado_tipo_asistencia',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_tipo_asistencia',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_tipo_asistencia' => 'boolean',
    ];


    /**
     * Retorna asistencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'id_tipo_asistencia');
    }


    /**
     * Retorna nombre_estado_tipo_asistencia
     *
     * @return string
     */
    public function getNombreEstadoTipoAsistenciaAttribute() : string
    {
        return $this->estado_tipo_asistencia ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Call the Auditable logic
        static::bootAuditable();
    }
}
