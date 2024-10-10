<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Presentacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    protected $table = 'presentacion';
    protected $primaryKey = 'id_presentacion';
    protected $fillable = [
        'id_presentacion',
        'descripcion_presentacion',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->hasOne(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presentacion) {
            $presentacion->created_by = Auth::id();
        });
        static::updating(function ($presentacion) {
            $presentacion->updated_by = Auth::id();
        });
        static::deleting(function ($presentacion) {
            $presentacion->deleted_by = Auth::id();
            $presentacion->save();
        });
    }
}
