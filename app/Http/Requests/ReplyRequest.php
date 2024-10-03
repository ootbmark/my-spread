<?php

namespace App\Http\Requests;

use App\Rules\DetectSpamKeywords;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'body' => 'required',
            'location' => 'required|string|max:255',
            'g-recaptcha-response' => 'required|captcha',
        ];

        if (Auth::user()->rola == 'admin') {
            $rules['user_id'] = 'required';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'body.required' => 'The body field is required.',
            'location.required' => 'The location field is required.',
            'user_id.required' => 'The user field is required for admins.',
            'g-recaptcha-response.required' => 'The Recaptcha field is Required.',
            'g-recaptcha-response.captcha' => 'The Recaptcha validation failed.',
        ];
    }
}
