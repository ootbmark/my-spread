<?php

namespace App\Http\Requests\Quiz\Answer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateAnswerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'data' => [
                'required',
                'array'
            ],
            'data.*.id' => [
                'required',
                'integer',
            ],
            'data.*.title' => [
//                'required',
                'string',
                'max:255'
            ],
            'data.*.file' => [
                'file',

//                'required_without_all:data.*.url'
            ],
            'data.*.file_type' => [
//                'required',
                Rule::in(
                    [
                        '',
                        'image',
                        'video',
                        'youtube',
                        'image_url',
                    ])

            ],

            'data.*.url' => [
//                'string',
//                'required_without_all:data.*.file'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
