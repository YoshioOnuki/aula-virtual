<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'id_usuario',
        'correo_usuario',
        'contrasenia_usuario',
        'foto_usuario',
        'estado_usuario',
        'id_persona',
        'id_rol',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function gestionAulaUsuario(){
        return $this->hasMany(GestionAulaUsuario::class, 'id_usuario');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            $usuario->created_by = auth()->id();
        });

        static::updating(function ($usuario) {
            $usuario->updated_by = auth()->id();
        });

        static::deleting(function ($usuario) {
            $usuario->deleted_by = auth()->id();
            $usuario->save();
        });
    }
}
