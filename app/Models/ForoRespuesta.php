<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ForoRespuesta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'foro_respuesta';
    protected $primaryKey = 'id_foro_respuesta';
    protected $fillable = [
        'id_foro_respuesta',
        'descripcion_foro_respuesta',
        'id_foro',
        'id_gestion_aula_usuario',
    ];

    public function foro()
    {
        return $this->belongsTo(Foro::class, 'id_foro');
    }

    public function gestionAulaUsuario()
    {
        return $this->belongsTo(GestionAulaUsuario::class, 'id_gestion_aula_usuario');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($foro_respuesta) {
            $foro_respuesta->created_by = Auth::id();
        });
        static::updating(function ($foro_respuesta) {
            $foro_respuesta->updated_by = Auth::id();
        });
        static::deleting(function ($foro_respuesta) {
            $foro_respuesta->deleted_by = Auth::id();
            $foro_respuesta->save();
        });
    }
}
