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
        'nombre_accion_usuario',
    ];

    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'id_accion_usuario');
    }

    public $timestamps = false;

}
