<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ComentarioTrabajoAcademico extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'comentario_trabajo_academico';
    protected $primaryKey = 'id_comentario_trabajo_academico';
    protected $fillable = [
        'id_comentario_trabajo_academico',
        'descripcion_comentario_trabajo_academico',
        'id_trabajo_academico_alumno',
        'id_gestion_aula_docente',
    ];


    /**
     * Retorna trabajoAcademicoAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trabajoAcademicoAlumno()
    {
        return $this->belongsTo(TrabajoAcademicoAlumno::class, 'id_trabajo_academico_alumno');
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Call the Auditable logic
        static::bootAuditable();

        static::creating(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->created_by = Auth::id();
        });
        static::updating(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->updated_by = Auth::id();
        });
        static::deleting(function ($comentario_trabajo_academico) {
            $comentario_trabajo_academico->deleted_by = Auth::id();
            $comentario_trabajo_academico->save();
        });
    }
}
