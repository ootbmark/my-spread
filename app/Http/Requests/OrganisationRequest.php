<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'short_name' => 'max:255',
            'phone' => 'max:50',
            'website' => 'max:255',
            'address' => 'max:255',
        ];

        if($this->method() == 'PATCH') {
            $rules['email'] = 'nullable|email|max:255|unique:organisations,email,' . $this->route('id');
        }else{
            $rules['email'] = 'nullable|email|max:255|unique:organisations';
        }

        return $rules;

    }
}
