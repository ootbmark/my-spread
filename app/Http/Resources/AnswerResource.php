<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_right' => $this->is_right,
            'file_url' => $this->file ? $this->file_url : null,
            'file_type' => $this->file_type,
            'url' => $this->url,
            'order' => $this->order,
        ];
    }
}
