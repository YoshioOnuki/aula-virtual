<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelAcademico extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'nivel_academico';
    protected $primaryKey = 'id_nivel_academico';
    protected $fillable = [
        'id_nivel_academico',
        'nombre_nivel_academico',
        'estado_nivel_academico',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_nivel_academico',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_nivel_academico' => 'boolean',
    ];


    /**
     * Retorna tipoPrograma
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tipoPrograma()
    {
        return $this->hasMany(TipoPrograma::class, 'id_nivel_academico');
    }


    /**
     * Retorna nombre_estado_nivel_academico
     *
     * @return string
     */
    public function getNombreEstadoNivelAcademicoAttribute() : string
    {
        return $this->estado_nivel_academico ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;


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
    }
}
