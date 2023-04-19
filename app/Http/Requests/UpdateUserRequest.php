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
            'name' => 'required|min:3|unique:users,name,' . $this->route('user')->id . ',id',
            'email'=>'required|email|unique:users,email,' . $this->route('user')->id . ',id',
            'isadmin'=>'required',
            
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
            'email.email' => 'Vul een geldig E-mail adres in',
            'isadmin.required' => 'Het veld privileges is verplicht'
        ];
    }
}
