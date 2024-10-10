<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ArchivoAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'archivo_alumno';
    protected $primaryKey = 'id_archivo_alumno';
    protected $fillable = [
        'id_archivo_alumno',
        'nombre_archivo_alumno',
        'archivo_alumno',
        'id_trabajo_academico_alumno',
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

        static::creating(function ($archivo_alumno) {
            $archivo_alumno->created_by = Auth::id();
        });
        static::updating(function ($archivo_alumno) {
            $archivo_alumno->updated_by = Auth::id();
        });
        static::deleting(function ($archivo_alumno) {
            $archivo_alumno->deleted_by = Auth::id();
            $archivo_alumno->save();
        });
    }
}
