<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Form
 * @package App\Http\Resources
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
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
            "start_publish" => !empty($this->start_publish) ? $this->start_publish->format('Y-m-d') : '',
            "end_publish" => !empty($this->end_publish) ? $this->end_publish->format('Y-m-d') : '',
            "questions" => new QuestionCollection($this->questions),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
