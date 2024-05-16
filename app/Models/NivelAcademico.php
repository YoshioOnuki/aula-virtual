<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelAcademico extends Model
{
    use HasFactory;

    protected $table = 'nivel_academico';
    protected $primaryKey = 'id_nivel_academico';
    protected $fillable = [
        'id_nivel_academico',
        'nombre_nivel_academico',
        'estado_nivel_academico',
    ];

    public function tipoPrograma()
    {
        return $this->hasMany(TipoPrograma::class, 'id_nivel_academico');
    }

    public $timestamps = false;
    
}
