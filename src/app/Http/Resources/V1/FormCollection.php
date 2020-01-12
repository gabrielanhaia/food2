<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class FormCollection
 * @package App\Http\Resources\V1
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class FormCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
