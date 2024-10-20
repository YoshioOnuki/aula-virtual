<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrograma extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'tipo_programa';
    protected $primaryKey = 'id_tipo_programa';
    protected $fillable = [
        'id_tipo_programa',
        'nombre_tipo_programa',
        'estado_tipo_programa',
        'id_nivel_academico',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_tipo_programa',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_tipo_programa' => 'boolean',
    ];


    /**
     * Retorna nivelAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelAcademico()
    {
        return $this->belongsTo(NivelAcademico::class, 'id_nivel_academico');
    }

    /**
     * Retorna programa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programa()
    {
        return $this->hasMany(Programa::class, 'id_tipo_programa');
    }


    /**
     * Retorna nombre_estado_tipo_programa
     *
     * @return string
     */
    public function getNombreEstadoTipoProgramaAttribute() : string
    {
        return $this->estado_tipo_programa ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to only include active tipo programas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_tipo_programa', $estado);
        }
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
