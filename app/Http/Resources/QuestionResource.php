<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'file_url' => $this->file ? $this->file_url : null,
            'file_type' => $this->file_type,
            'url' => $this->url,
            'order' => $this->order,
            'answers' => $this->answers,
            'question_info' => $this->question_info,
            'is_priority' => $this->is_priority,
            'question_required' => $this->question_required,
        ];
    }
}
