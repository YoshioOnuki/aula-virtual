<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    protected $fillable = [
        'id_rol',
        'nombre_rol',
        'estado_rol',
    ];

    protected $casts = [
        'estado_rol' => 'boolean',
    ];

    public function usuarios() {
        return $this->belongsToMany(Usuario::class, 'usuario_rol', 'id_rol', 'id_usuario');
    }

    public function usuarioRol()
    {
        return $this->hasMany(UsuarioRol::class, 'id_rol');
    }

    public $timestamps = false;

}
