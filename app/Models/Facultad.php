<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'facultad';
    protected $primaryKey = 'id_facultad';
    protected $fillable = [
        'id_facultad',
        'nombre_facultad',
        'estado_facultad',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_facultad',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_facultad' => 'boolean',
    ];


    /**
     * Retorna programa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programa()
    {
        return $this->hasMany(Programa::class, 'id_facultad');
    }

    /**
     * Retorna autoridad
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autoridad()
    {
        return $this->hasMany(Autoridad::class, 'id_facultad');
    }


    /**
     * Retorna nombre_estado_facultad
     *
     * @return string
     */
    public function getNombreEstadoFacultadAttribute() : string
    {
        return $this->estado_facultad ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to only include active facultades.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_facultad', $estado);
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
