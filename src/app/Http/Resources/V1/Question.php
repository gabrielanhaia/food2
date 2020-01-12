<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Question
 * @package App\Http\Resources
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "form_id" => $this->form_id,
            "description" => (string)$this->description,
            "mandatory" => $this->mandatory,
            "type" => $this->type,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
