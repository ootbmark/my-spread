<?php

namespace App\Http\Requests;

use App\Models\Organisation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->route('id')],
            'personal_email' => ['nullable', 'email', 'max:255', 'unique:users,personal_email,' . $this->route('id')],
            'location' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'organisation_id' => ['required'],
            'reg_source' => ['required', 'string', 'max:255'],
            'why_spread' => ['required', 'string'],
            'allowed_companies' => ['array', 'exists:companies,id'],
            'allowed_workshops' => ['array', 'exists:quizes,id'],
        ];

        $organisation = Organisation::find($this->get('organisation_id'));
        if($organisation && $organisation->type == 'student'){
            $rules['university_id'] = ['required'];
        }

        if($this->get('reg_source') == 'Others'){
            $rules['other_reg_source'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}
