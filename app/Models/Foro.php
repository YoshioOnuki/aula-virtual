<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Foro extends Model
{
    use HasFactory;
    use SoftDeletes;

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
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_completo_docente',
        'nombre_curso',
    ];

    /**
     * Los atributos que deben ocultarse.
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
     * Get the nombre_completo_docente attribute.
     *
     * @return string
     */
    public function getNombreCompletoDocenteAttribute(): string
    {
        return $this->gestionAulaDocente->nombre_completo_docente;
    }

    /**
     * Get the nombre_curso attribute.
     *
     * @return string
     */
    public function getNombreCursoAttribute(): string
    {
        return $this->gestionAula->nombre_curso;
    }


    /**
     * El método "arrancado" del modelo.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

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
