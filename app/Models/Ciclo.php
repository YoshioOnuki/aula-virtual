<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'ciclo';
    protected $primaryKey = 'id_ciclo';
    protected $fillable = [
        'id_ciclo',
        'numero_ciclo',
        'nombre_ciclo',
        'estado_ciclo',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_ciclo',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_ciclo' => 'boolean',
    ];


    /**
     * Retorna curso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_ciclo');
    }


    /**
     * Retorna nombre_estado_ciclo
     *
     * @return string
     */
    public function getNombreEstadoCicloAttribute() : string
    {
        return $this->estado_ciclo ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to only include active ciclos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado_ciclo', $estado);
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
