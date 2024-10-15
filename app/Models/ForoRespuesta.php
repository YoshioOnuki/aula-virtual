<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ForoRespuesta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'foro_respuesta';
    protected $primaryKey = 'id_foro_respuesta';
    protected $fillable = [
        'id_foro_respuesta',
        'descripcion_foro_respuesta',
        'id_foro',
        'id_gestion_aula_alumno',
    ];


    /**
     * Retorna foro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foro()
    {
        return $this->belongsTo(Foro::class, 'id_foro');
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($foro_respuesta) {
            $foro_respuesta->created_by = Auth::id();
        });
        static::updating(function ($foro_respuesta) {
            $foro_respuesta->updated_by = Auth::id();
        });
        static::deleting(function ($foro_respuesta) {
            $foro_respuesta->deleted_by = Auth::id();
            $foro_respuesta->save();
        });
    }
}
