<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'personal_email' => ['nullable', 'email', 'max:255', 'unique:users,personal_email,' . Auth::id()],
            'location' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'organisation_id' => ['required']
        ];
    }
}
