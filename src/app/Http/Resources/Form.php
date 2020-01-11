<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Form extends JsonResource
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
            "user_id" => $this->user_id,
            "name" => $this->name,
            "description" => $this->description,
            "introduction" => $this->introduction,
            "start_publish" => $this->start_publish,
            "end_publish" => $this->end_publish,
            "questions" => new QuestionCollection($this->questions),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
