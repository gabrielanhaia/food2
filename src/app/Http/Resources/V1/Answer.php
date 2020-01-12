<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Answer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "question_id" => $this->question_id,
            "valid_value" => $this->valid_value,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
