<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Proceso extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'proceso';
    protected $primaryKey = 'id_proceso';
    protected $fillable = [
        'id_proceso',
        'nombre_proceso',
        'estado_proceso',
    ];


    /**
     * Las marcas de tiempo que deben ser añadidas.
     *
     * @var bool
     */
    protected $appends = [
        'nombre_estado_proceso',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_proceso' => 'boolean',
    ];


    /**
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionAula()
    {
        return $this->hasMany(GestionAula::class, 'id_proceso');
    }

    /**
     * Retorna usuarioRegistra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioRegistra()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }

    /**
     * Retorna usuarioActualiza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioActualiza()
    {
        return $this->belongsTo(Usuario::class, 'updated_by');
    }

    /**
     * Retorna usuarioElimina
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioElimina()
    {
        return $this->belongsTo(Usuario::class, 'deleted_by');
    }


    /**
     * Retorna nombre_estado_proceso
     *
     * @return string
     */
    public function getNombreEstadoProcesoAttribute() : string
    {
        return $this->estado_proceso ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to only include active proceso.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado_proceso', $estado);
        }
    }


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

        static::creating(function ($proceso) {
            $proceso->created_by = Auth::id();
        });
        static::updating(function ($proceso) {
            $proceso->updated_by = Auth::id();
        });
        static::deleting(function ($proceso) {
            $proceso->deleted_by = Auth::id();
            $proceso->save();
        });
    }
}
