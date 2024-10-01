<?php

namespace App;

use App\Models\Accion;

trait GetActionId
{
    public function getActionId($action)
    {
        return Accion::where('nombre_accion', $action)->first()->id_accion;
    }
}
