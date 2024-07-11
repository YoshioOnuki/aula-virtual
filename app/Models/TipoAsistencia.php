<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAsistencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_asistencia';
    protected $primaryKey = 'id_tipo_asistencia';
    protected $fillable = [
        'id_tipo_asistencia',
        'nombre_tipo_asistencia',
        'estado_tipo_asistencia',
    ];

    public function asistencia()
    {
        return $this->hasMany(Asistencia::class, 'id_tipo_asistencia');
    }

    public $timestamps = false;
}
