<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoridad extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'autoridad';
    protected $primaryKey = 'id_autoridad';
    protected $fillable = [
        'id_autoridad',
        'nombre_autoridad',
        'foto_autoridad',
        'estado_autoridad',
        'id_cargo',
        'id_facultad',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_autoridad',
        'solo_primeros_nombres',
        'mostrar_foto',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_autoridad' => 'boolean',
    ];


    /**
     * Retorna cargo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }

    /**
     * Retorna facultad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }


    /**
     * Get the nombre_estado_autoridad attribute.
     *
     * @return string
     */
    public function getNombreEstadoAutoridadAttribute(): string
    {
        return $this->estado_autoridad ? 'Activo' : 'Inactivo';
    }

    /**
     * Get the solo_primeros_nombres attribute.
     *
     * @return string
     */
    public function getSoloPrimerosNombresAttribute()
    {
        //Primero separo los nombres de los grados (Dr., Ing., Mg., etc)
        $nombres = explode('.', $this->nombre_autoridad);
        //Luego separo los nombres
        $nombres = explode(' ', $nombres[1]);
        //Retorno solo los primeros nombres
        return $nombres[0] . ' ' . $nombres[1];
    }

    /**
     * Get the mostrar_foto attribute.
     *
     * @return string
     */
    public function getMostrarFotoAttribute(): string
    {
        return $this->foto_autoridad || $this->foto_autoridad != '' ? $this->foto_autoridad :
            'https://ui-avatars.com/api/?name=' . $this->solo_primeros_nombres . '&size=64&&color=' . config('settings.color_lt_autoridades') . '&background=' . config('settings.color_autoridades') . '&bold=true';
    }


    /**
     * Scope a query to search
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nombre_autoridad', 'LIKE', '%' . $search . '%')
            ->orWhereHas('facultad', function ($query) use ($search) {
                $query->where('nombre_facultad', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('cargo', function ($query) use ($search) {
                $query->where('nombre_cargo', 'LIKE', '%' . $search . '%');
            });
    }


    /**
     * Scope a query to search by estado activo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivo($query)
    {
        return $query->where('estado_autoridad', 1);
    }

    /**
     * Scope a query to search by estado inactivo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivo($query)
    {
        return $query->where('estado_autoridad', 0);
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
