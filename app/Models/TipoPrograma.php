<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrograma extends Model
{
    use HasFactory;

    protected $table = 'tipo_programa';
    protected $primaryKey = 'id_tipo_programa';
    protected $fillable = [
        'id_tipo_programa',
        'nombre_tipo_programa',
        'estado_tipo_programa',
        'id_nivel_academico',
    ];

    protected $casts = [
        'estado_tipo_programa' => 'boolean',
    ];

    public function nivelAcademico()
    {
        return $this->belongsTo(NivelAcademico::class, 'id_nivel_academico');
    }

    public function programa()
    {
        return $this->hasMany(Programa::class, 'id_tipo_programa');
    }

    public $timestamps = false;
}
