<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'time_limit' =>  $this->time_limit ? date('Y-m-d', strtotime($this->time_limit)) : '',
            'answer_by_one' => $this->answer_by_one,
            'slug' => $this->slug,
            'questions' => QuestionResource::collection($this->questions),
            'groups' => $this->groups->pluck('id'),
            'company_id' => $this->company_id,
        ];
    }
}
