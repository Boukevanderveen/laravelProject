<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|min:3|max:55|unique:users',
            'email'=>'required|email|max:255|unique:users',
            'password' => 'required|max:255'
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
            'name.max' => 'De naam mag niet meer dan :max karakters bevatten',
            'name.unique' => 'Deze naam is al in gebruik',
            'email.required' => 'De email is verplicht',
            'email.max' => 'De E-mail mag niet meer dan :max karakters bevatten',
            'email.unique' => 'Dit E-mailadres is al in gebruik',
            'email.email' => 'Vul een geldig E-mail adres in',
            'password.required' => 'Het wachtwoord is verplicht',
            'password.max' => 'Het wachtwoord mag niet meer dan :max karakters bevatten',
        ];
    }
}
