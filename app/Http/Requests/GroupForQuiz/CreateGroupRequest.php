<?php

namespace App\Http\Requests\GroupForQuiz;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ]
        ];
    }
}