<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presentacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'presentacion';
    protected $primaryKey = 'id_presentacion';
    protected $fillable = [
        'id_presentacion',
        'descripcion_presentacion',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presentacion) {
            $presentacion->created_by = auth()->id();
        });
        static::updating(function ($presentacion) {
            $presentacion->updated_by = auth()->id();
        });
        static::deleting(function ($presentacion) {
            $presentacion->deleted_by = auth()->id();
            $presentacion->save();
        });
    }
}
