<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Silabus extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'silabus';
    protected $primaryKey = 'id_silabus';
    protected $fillable = [
        'id_silabus',
        'archivo_silabus',
        'id_gestion_aula',
    ];


    /**
     * Retorna gestionAula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAula()
    {
        return $this->hasOne(GestionAula::class, 'id_gestion_aula');
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

        static::creating(function ($silabus) {
            $silabus->created_by = Auth::id();
        });
        static::updating(function ($silabus) {
            $silabus->updated_by = Auth::id();
        });
        static::deleting(function ($silabus) {
            $silabus->deleted_by = Auth::id();
            $silabus->save();
        });
    }
}
