<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'emails' => ['required', function ($attribute, $value, $fail) {
                $rawEmails = preg_replace('/[ ]/','', $value);
                $emails = explode(';',  $rawEmails);
                $validEmails = array_filter(filter_var_array($emails, FILTER_VALIDATE_EMAIL));
                $invalidEmailCount = count($emails) - count($validEmails);
                if ($invalidEmailCount > 0) {
                    $fail('The '.$attribute.' is invalid.');
                }
            },],
        ];
    }
}
