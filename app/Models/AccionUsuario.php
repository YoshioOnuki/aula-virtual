<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionUsuario extends Model
{
    use HasFactory;

    protected $table = 'accion_usuario';
    protected $primaryKey = 'id_accion_usuario';
    protected $fillable = [
        'id_accion_usuario',
        'ruta_accion_usuario',
        'fecha_accion_usuario',
        'id_usuario',
        'id_accion'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function accion()
    {
        return $this->belongsTo(Accion::class, 'id_accion');
    }

    public $timestamps = false;

}
