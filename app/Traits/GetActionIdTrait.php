<?php

namespace App\Traits;

use App\Models\Accion;

trait GetActionIdTrait
{
    public function getActionId($action)
    {
        return Accion::where('nombre_accion', $action)->first()->id_accion;
    }
}
