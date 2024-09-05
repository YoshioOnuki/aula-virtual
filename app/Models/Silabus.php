<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Silabus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'silabus';
    protected $primaryKey = 'id_silabus';
    protected $fillable = [
        'id_silabus',
        'archivo_silabus',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->hasOne(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($silabus) {
            $silabus->created_by = Auth::id();
        });
        static::updating(function ($silabus) {
            $silabus->updated_by = Auth::id();
        });
        static::deleting(function ($silabus) {
            $silabus->deleted_by = Auth::id();
            $silabus->save();
        });
    }
}
