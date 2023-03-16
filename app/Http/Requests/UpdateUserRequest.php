<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:users',
            'email'=>'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }

                            /** 
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht',
            'name.min' => 'De naam moet minimaal 3 letters bevatten',
            'name.unique' => 'Deze naam is al in gebruik',
            'email.required' => 'De email is verplicht',
            'email.unique' => 'Dit E-mailadres is al in gebruik',
            'password.required' => 'Het wachtwoord is verplicht',
            'password.min' => 'Het wachtwoord moet minimaal 6 letters bevatten',
        ];
    }
}
