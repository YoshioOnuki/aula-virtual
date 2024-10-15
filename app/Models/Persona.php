<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = [
        'id_persona',
        'documento_persona',
        'nombres_persona',
        'apellido_paterno_persona',
        'apellido_materno_persona',
        'codigo_alumno_persona',
        'correo_persona',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_completo',
        'solo_primeros_nombres',
        'foto',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'documento_persona' => 'integer',
    ];


    /**
     * Retorna usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_persona');
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
     * Get the nombre_completo attribute.
     *
     * @return string
     */
    public function getNombreCompletoAttribute() : string
    {
        return $this->nombres_persona . ' ' . $this->apellido_paterno_persona . ' ' . $this->apellido_materno_persona;
    }

    /**
     * Get the solo_primeros_nombres attribute.
     *
     * @return string
     */
    public function getSoloPrimerosNombresAttribute() : string
    {
        $nombres = explode(' ', $this->nombres_persona);
        return $nombres[0] . ' ' . $this->apellido_paterno_persona;
    }

    /**
     * Get the foto attribute.
     *
     * @return string
     */
    public function getFotoAttribute() : string
    {
        return $this->usuario->first()->foto_usuario ?? '';
    }


    /**
     * Scope a query to search persona.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where('nombres_persona', 'LIKE', "%$search%")
            ->orWhere('apellido_paterno_persona', 'LIKE', "%$search%")
            ->orWhere('apellido_materno_persona', 'LIKE', "%$search%")
            ->orWhere('codigo_alumno_persona', 'LIKE', "%$search%")
            ->orWhere('correo_persona', 'LIKE', "%$search%");
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

        static::creating(function ($persona) {
            $persona->created_by = Auth::id();
        });

        static::updating(function ($persona) {
            $persona->updated_by = Auth::id();
        });

        static::deleting(function ($persona) {
            $persona->deleted_by = Auth::id();
            $persona->save();
        });
    }
}
