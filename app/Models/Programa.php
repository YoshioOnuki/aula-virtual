<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $table = 'programa';
    protected $primaryKey = 'id_programa';
    protected $fillable = [
        'id_programa',
        'nombre_programa',
        'mencion_programa',
        'estado_programa',
        'id_facultad',
        'id_tipo_programa',
    ];


    /**
     * Los atributos que deben ser añadidos.
     *
     * @var array
     */
    protected $appends = [
        'nombre_estado_programa',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'estado_programa' => 'boolean',
    ];


    /**
     * Retorna facultad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }

    /**
     * Retorna tipoPrograma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPrograma()
    {
        return $this->belongsTo(TipoPrograma::class, 'id_tipo_programa');
    }

    /**
     * Retorna curso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_programa');
    }


    /**
     * Retorna nombre_estado_programa
     *
     * @return string
     */
    public function getNombreEstadoProgramaAttribute() : string
    {
        return $this->estado_programa ? 'Activo' : 'Inactivo';
    }


    /**
     * Las marcas de tiempo que deben ser deshabilitadas.
     */
    public $timestamps = false;
}
