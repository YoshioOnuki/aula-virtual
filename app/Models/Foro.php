<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Foro extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'foro';
    protected $primaryKey = 'id_foro';
    protected $fillable = [
        'id_foro',
        'titulo_foro',
        'descripcion_foro',
        'fecha_inicio_foro',
        'fecha_fin_foro',
        'id_gestion_aula_docente',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_inicio_foro' => 'datetime',
        'fecha_fin_foro' => 'datetime',
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
     * Retorna gestionAulaDocente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAulaDocente()
    {
        return $this->belongsTo(GestionAulaDocente::class, 'id_gestion_aula_docente');
    }

    /**
     * Retorna foroRespuesta
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foroRespuesta()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_foro');
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

        static::creating(function ($foro) {
            $foro->created_by = Auth::id();
        });
        static::updating(function ($foro) {
            $foro->updated_by = Auth::id();
        });
        static::deleting(function ($foro) {
            $foro->deleted_by = Auth::id();
            $foro->save();
        });
    }
}
