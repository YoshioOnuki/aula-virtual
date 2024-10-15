<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrabajoAcademico extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trabajo_academico';
    protected $primaryKey = 'id_trabajo_academico';
    protected $fillable = [
        'id_trabajo_academico',
        'titulo_trabajo_academico',
        'descripcion_trabajo_academico',
        'fecha_inicio_trabajo_academico',
        'fecha_fin_trabajo_academico',
        'id_gestion_aula',
    ];


    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_inicio_trabajo_academico' => 'datetime',
        'fecha_fin_trabajo_academico' => 'datetime',
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
     * Retorna trabajoAcademicoAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trabajoAcademicoAlumno()
    {
        return $this->hasMany(TrabajoAcademicoAlumno::class, 'id_trabajo_academico');
    }

    /**
     * Retorna archivoDocente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archivoDocente()
    {
        return $this->hasMany(ArchivoDocente::class, 'id_trabajo_academico');
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

        static::creating(function ($trabajo_academico) {
            $trabajo_academico->created_by = Auth::id();
        });
        static::updating(function ($trabajo_academico) {
            $trabajo_academico->updated_by = Auth::id();
        });
        static::deleting(function ($trabajo_academico) {
            $trabajo_academico->deleted_by = Auth::id();
            $trabajo_academico->save();
        });
    }
}
