<?php

namespace App\Traits;

use App\Models\Accion;

trait GetActionIdTrait
{
    public function get_action_id($action)
    {
        return Accion::where('nombre_accion', $action)->first()->id_accion;
    }
}
