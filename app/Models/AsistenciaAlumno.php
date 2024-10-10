<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AsistenciaAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asistencia_alumno';
    protected $primaryKey = 'id_asistencia_alumno';
    protected $fillable = [
        'id_asistencia_alumno',
        'id_asistencia',
        'id_estado_asistencia',
        'id_gestion_aula_alumno',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_asistencia',
        'nombre_completo_alumno',
    ];


    /**
     * Retorna asistencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id_asistencia');
    }

    /**
     * Retorna estadoAsistencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoAsistencia()
    {
        return $this->belongsTo(EstadoAsistencia::class, 'id_estado_asistencia');
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
     * Get the nombre_estado_asistencia attribute.
     *
     * @return string
     */
    public function getNombreEstadoAsistenciaAttribute(): string
    {
        return $this->estadoAsistencia->nombre_estado_asistencia;
    }

    /**
     * Get the nombre_completo_alumno attribute.
     *
     * @return string
     */
    public function getNombreCompletoAlumnoAttribute(): string
    {
        return $this->gestionAulaAlumno->nombre_completo_alumno;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asistencia_alumno) {
            $asistencia_alumno->created_by = Auth::id();
        });
        static::updating(function ($asistencia_alumno) {
            $asistencia_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($asistencia_alumno) {
            $asistencia_alumno->deleted_by = Auth::id();
            $asistencia_alumno->save();
        });
    }
}
