<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
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
        return [
            'emails' => 'required|array|min:1',
            'emails.0' => 'required|email',
        ];
    }


    public function messages()
    {
        return [
            'emails.*.required' => 'Friend email is required',
            'emails.*.email' => 'Friend email must be a valid email address.
'
        ];
    }
}
