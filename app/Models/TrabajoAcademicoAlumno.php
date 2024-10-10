<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrabajoAcademicoAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trabajo_academico_alumno';
    protected $primaryKey = 'id_trabajo_academico_alumno';
    protected $fillable = [
        'id_trabajo_academico_alumno',
        'descripcion_trabajo_academico_alumno',
        'nota_trabajo_academico_alumno',
        'id_estado_trabajo_academico',
        'id_trabajo_academico',
        'id_gestion_aula_alumno',
    ];

    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_completo_alumno',
        'nombre_estado_trabajo_academico',
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
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'nota_trabajo_academico_alumno' => 'decimal:2',
    ];


    /**
     * Retorna estadoTrabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoTrabajoAcademico()
    {
        return $this->belongsTo(EstadoTrabajoAcademico::class, 'id_estado_trabajo_academico');
    }

    /**
     * Retorna trabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trabajoAcademico()
    {
        return $this->belongsTo(TrabajoAcademico::class, 'id_trabajo_academico');
    }

    /**
     * Retorna gestionAulaAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gestionAulaAlumno()
    {
        return $this->belongsTo(GestionAulaAlumno::class, 'id_gestion_aula_alumno');
    }

    /**
     * Retorna comentarioTrabajoAcademico
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarioTrabajoAcademico()
    {
        return $this->hasMany(ComentarioTrabajoAcademico::class, 'id_trabajo_academico_alumno');
    }

    /**
     * Retorna archivoAlumno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archivoAlumno()
    {
        return $this->hasMany(ArchivoAlumno::class, 'id_trabajo_academico_alumno');
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
     * Retorna nombre_completo_alumno
     *
     * @return string
     */
    public function getNombreCompletoAlumnoAttribute(): string
    {
        return $this->gestionAulaAlumno->nombre_completo_alumno;
    }

    /**
     * Retorna nombre_estado_trabajo_academico
     *
     * @return string
     */
    public function getNombreEstadoTrabajoAcademicoAttribute(): string
    {
        return $this->estadoTrabajoAcademico->nombre_estado_trabajo_academico;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->created_by = Auth::id();
        });
        static::updating(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($trabajo_academico_alumno) {
            $trabajo_academico_alumno->deleted_by = Auth::id();
            $trabajo_academico_alumno->save();
        });
    }
}
