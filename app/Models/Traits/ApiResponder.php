<?php

namespace App\Models\Traits;
trait ApiResponder
{
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }
}