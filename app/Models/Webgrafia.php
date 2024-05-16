<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webgrafia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'webgrafia';
    protected $primaryKey = 'id_webgrafia';
    protected $fillable = [
        'id_webgrafia',
        'link_id_webgrafia',
        'id_gestion_aula',
    ];

    public function gestionAula()
    {
        return $this->belongsTo(GestionAula::class, 'id_gestion_aula');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($webgrafia) {
            $webgrafia->created_by = auth()->id();
        });
        static::updating(function ($webgrafia) {
            $webgrafia->updated_by = auth()->id();
        });
        static::deleting(function ($webgrafia) {
            $webgrafia->deleted_by = auth()->id();
            $webgrafia->save();
        });
    }
}
