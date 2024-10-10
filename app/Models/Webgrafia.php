<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Webgrafia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'webgrafia';
    protected $primaryKey = 'id_webgrafia';
    protected $fillable = [
        'id_webgrafia',
        'descripcion_webgrafia',
        'link_webgrafia',
        'id_gestion_aula',
    ];

    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_curso',
    ];

    /**
     * Los atributos que deben ser ocultados.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    /**
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
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
     * Retorna nombre_curso
     *
     * @return string
     */
    public function getNombreCursoAttribute(): string
    {
        return $this->gestionAula->nombre_curso;
    }


    /**
     * Scope a query to search webgrafia.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search == null) {
            return $query;
        }

        return $query->where('descripcion_webgrafia', 'LIKE', "%$search%")
            ->orWhere('link_webgrafia', 'LIKE', "%$search%");
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($webgrafia) {
            $webgrafia->created_by = Auth::id();
        });
        static::updating(function ($webgrafia) {
            $webgrafia->updated_by = Auth::id();
        });
        static::deleting(function ($webgrafia) {
            $webgrafia->deleted_by = Auth::id();
            $webgrafia->save();
        });
    }
}
