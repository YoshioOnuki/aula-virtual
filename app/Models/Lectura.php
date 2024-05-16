<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lectura extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lectura';
    protected $primaryKey = 'id_lectura';
    protected $fillable = [
        'id_lectura',
        'nombre_lectura',
        'archivo_lectura',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lectura) {
            $lectura->created_by = auth()->id();
        });
        static::updating(function ($lectura) {
            $lectura->updated_by = auth()->id();
        });
        static::deleting(function ($lectura) {
            $lectura->deleted_by = auth()->id();
            $lectura->save();
        });
    }
}
