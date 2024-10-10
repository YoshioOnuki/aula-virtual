<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Recurso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'recurso';
    protected $primaryKey = 'id_recurso';
    protected $fillable = [
        'id_recurso',
        'nombre_recurso',
        'archivo_recurso',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nombre_recurso', 'LIKE', "%$search%");
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recurso) {
            $recurso->created_by = Auth::id();
        });
        static::updating(function ($recurso) {
            $recurso->updated_by = Auth::id();
        });
        static::deleting(function ($recurso) {
            $recurso->deleted_by = Auth::id();
            $recurso->save();
        });
    }
}
