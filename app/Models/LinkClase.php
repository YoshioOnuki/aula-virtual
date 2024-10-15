<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LinkClase extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'link_clase';
    protected $primaryKey = 'id_link_clase';
    protected $fillable = [
        'id_link_clase',
        'nombre_link_clase',
        'estado_link_clase',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_link_clase',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_link_clase' => 'boolean',
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
     * Retorna nombre_estado_link_clase
     *
     * @return string
     */
    public function getNombreEstadoLinkClaseAttribute() : string
    {
        return $this->estado_link_clase ? 'Activo' : 'Inactivo';
    }


    /**
     * Scope a query to search
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $id_gestion_aula
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGestionAula($query, $id_gestion_aula)
    {
        if ($id_gestion_aula) {
            return $query->where('id_gestion_aula', $id_gestion_aula);
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

        static::creating(function ($link_clase) {
            $link_clase->created_by = Auth::id();
        });
        static::updating(function ($link_clase) {
            $link_clase->updated_by = Auth::id();
        });
        static::deleting(function ($link_clase) {
            $link_clase->deleted_by = Auth::id();
            $link_clase->save();
        });
    }
}
