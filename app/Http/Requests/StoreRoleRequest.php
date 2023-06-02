<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|min:2|max:55|unique:roles',
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
            'name.min' => 'De naam moet minimaal 2 letters zijn',
            'name.max' => 'De naam mag niet meer dan :max karakters bevatten',
            'name.unique' => 'Er bestaat al een rol met deze naam',
        ];
    }
}
