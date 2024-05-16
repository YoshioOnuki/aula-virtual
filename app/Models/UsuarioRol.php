<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'usuario_rol';
    protected $primaryKey = 'id_usuario_rol';
    protected $fillable = [
        'id_usuario_rol',
        'nombre_usuario_rol',
        'estado_usuario_rol',
    ];

    public $timestamps = false;
    
    public function gestionAulaUsuario(){
        return $this->hasMany(GestionAulaUsuario::class, 'id_usuario_rol');
    }
}
