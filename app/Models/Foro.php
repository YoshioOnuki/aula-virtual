<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foro extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'foro';
    protected $primaryKey = 'id_foro';
    protected $fillable = [
        'id_foro',
        'titulo_foro',
        'descripcion_foro',
        'fecha_inicio_foro',
        'fecha_fin_foro',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function foroRespuesta()
    {
        return $this->hasMany(ForoRespuesta::class, 'id_foro');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($foro) {
            $foro->created_by = auth()->id();
        });
        static::updating(function ($foro) {
            $foro->updated_by = auth()->id();
        });
        static::deleting(function ($foro) {
            $foro->deleted_by = auth()->id();
            $foro->save();
        });
    }
}
