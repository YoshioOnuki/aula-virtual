<?php

namespace App\Models;

use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    use HasFactory;
    use AuditableTrait;

    protected $table = 'usuario_rol';
    protected $primaryKey = 'id_usuario_rol';
    protected $fillable = [
        'id_usuario_rol',
        'id_usuario',
        'id_rol',
    ];


    /**
     * Retorna usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Retorna rol
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }


    /**
     * Retorna usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public $timestamps = false;


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Call the Auditable logic
        static::bootAuditable();
    }
}
