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

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }

    public function tipoPrograma()
    {
        return $this->belongsTo(TipoPrograma::class, 'id_tipo_programa');
    }

    public function curso()
    {
        return $this->hasMany(Curso::class, 'id_programa');
    }
}
